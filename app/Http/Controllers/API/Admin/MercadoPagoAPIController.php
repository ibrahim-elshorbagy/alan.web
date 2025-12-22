<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\CouponCode;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\AffiliateUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use WandesCardoso\MercadoPago\DTO\Item;
use WandesCardoso\MercadoPago\DTO\Payer;
use App\Http\Controllers\AppBaseController;
use WandesCardoso\MercadoPago\DTO\BackUrls;
use App\Mail\SubscriptionPaymentSuccessMail;
use App\Repositories\SubscriptionRepository;
use WandesCardoso\MercadoPago\DTO\Preference;
use WandesCardoso\MercadoPago\Facades\MercadoPago;

class MercadoPagoAPIController extends AppBaseController
{
    private $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function onBoard(Request $request)
    {
        config(['mercadopago.access_token' => getSelectedPaymentGateway('mp_access_token')]);
        config(['mercadopago.public_key' => getSelectedPaymentGateway('mp_public_key')]);

        if (getSelectedPaymentGateway('mp_public_key') == null || getSelectedPaymentGateway('mp_access_token') == null) {
            return $this->sendError('Mercado Pago credentials not found.');
        }

        $planId = $request->input('planId');
        $customFieldId = $request->input('customFieldId');
        $couponCodeId = $request->input('couponCodeId');
        $couponCode = $request->input('couponCode');

        $plan = Plan::findOrFail($planId);

        if (isset($plan->currency->currency_code) && ! in_array(
                strtoupper($plan->currency->currency_code),
                getMercadoPagoSupportedCurrencies()
            )) {
                return $this->sendError(__('messages.placeholder.this_currency_is_not_supported_mercadopago'));
        }

        if ($plan->custom_select == 1) {
            if (empty($customFieldId)) {
                return $this->sendError('Please select a custom option for this plan.');
            }

            $validCustomField = $plan->planCustomFields()->where('id', $customFieldId)->exists();
            if (!$validCustomField) {
                return $this->sendError('Invalid custom field selection for this plan. Please select a valid option.');
            }
        } else {
            if (!empty($customFieldId)) {
                return $this->sendError('This plan does not have custom options.');
            }
        }

        if (!empty($couponCodeId) && !empty($couponCode)) {
            $couponCodeRecord = CouponCode::where('id', $couponCodeId)
                ->where('coupon_name', $couponCode)
                ->where('status', 1)
                ->first();

            if (!$couponCodeRecord) {
                return $this->sendError('Invalid or inactive coupon code.');
            }

            $currentDate = Carbon::now();

            if ($currentDate->gt(Carbon::parse($couponCodeRecord->expire_at))) {
                return $this->sendError('This coupon code has expired.');
            }

            if ($couponCodeRecord->coupon_limit !== null && $couponCodeRecord->coupon_limit_left <= 0) {
                return $this->sendError('This coupon code has reached its usage limit.');
            }
        }

        $currentSubscription = getCurrentSubscription();
        if ($currentSubscription && $currentSubscription->plan_id == $planId) {
            $currentDate = Carbon::now();
            $expiresAt = Carbon::parse($currentSubscription->ends_at);

            if ($expiresAt->gt($currentDate)) {
                return $this->sendError('You already have this active subscription plan.');
            }
        }

        $data = $this->subscriptionRepository->manageSubscription($request->all());

        if (isset($data['status']) && $data['status'] === true) {
            return $this->sendResponse([
                'plan' => $data['subscriptionPlan'],
            ], 'Plan activated successfully.');
        }

        if (!isset($data['subscription'])) {
            return $this->sendError('Failed to create subscription.');
        }

        try {
            $subscription = $data['subscription'];
            $plan = $data['plan'];

            $payer = new Payer(
                Auth::user()->first_name,
                Auth::user()->last_name,
                Auth::user()->email
            );

            // Create item
            $item = Item::make()
                ->setTitle($plan->name)
                ->setQuantity(1)
                ->setId(Auth::user()->id)
                ->setCategoryId($subscription->id)
                ->setUnitPrice((int)$data['amountToPay']);

            // Create preference
            $preference = Preference::make()
                ->setPayer($payer)
                ->addItem($item)
                ->setBackUrls(new BackUrls(route('mercadopago.success')))
                ->setAutoReturn('approved')
                ->setExternalReference($plan->id);

            $response = MercadoPago::preference()->create($preference);
            $response['body']->items[0]->currency_id = strtoupper($subscription->plan->currency->currency_code);

            $preferenceId = $response['body']->id ?? null;
            $initPoint = $response['body']->init_point ?? null;
            return $this->sendResponse([
                'preferenceId' => $preferenceId,
                'initPoint' => $initPoint,
                'amount' => $data['amountToPay'],
                'plan' => $plan,
                'subscription' => $subscription,
            ], 'MercadoPago payment preference created successfully.');
        } catch (Exception $e) {
            Log::error('MercadoPago onBoard error: ' . $e->getMessage());
            return $this->sendError('Failed to create MercadoPago payment preference: ' . $e->getMessage(), 500);
        }
    }
    public function paymentSuccess(Request $request)
    {
        $input = $request->all();

        config(['mercadopago.access_token' => getSelectedPaymentGateway('mp_access_token')]);
        config(['mercadopago.public_key' => getSelectedPaymentGateway('mp_public_key')]);

        if (getSelectedPaymentGateway('mp_public_key') == null || getSelectedPaymentGateway('mp_access_token') == null) {
           return $this->sendError('Mercado Pago credentials not found.');
        }

        if (empty($input['payment_id'])) {
            return $this->sendError('Payment ID is required.', 400);
        }

        try {
            $paymentResponse = mercadoPago()->payment()->find($input['payment_id']);

            if ($paymentResponse['httpCode'] != 200) {
                return $this->sendError('Payment verification failed or payment not found.', 400);
            }

            $paymentBody = $paymentResponse['body'];

            if ($paymentBody->status !== 'approved') {
                return $this->sendError('Payment not approved.', 400);
            }

            DB::beginTransaction();

            $amount = $paymentBody->transaction_amount;
            $subscriptionId = $paymentBody->additional_info->items[0]->category_id;
            $userId = $paymentBody->additional_info->items[0]->id;

            $user = Auth::user();
            if ($user->id != $userId) {
                $user = User::findOrFail($userId);
            }

            $subscription = Subscription::findOrFail($subscriptionId);

            $subscription->update([
                'payment_type' => Subscription::MERCADO_PAGO,
                'status' => Subscription::ACTIVE,
            ]);

            Subscription::whereTenantId($subscription->tenant_id)
                ->where('id', '!=', $subscriptionId)
                ->where('status', '!=', Subscription::REJECT)
                ->update(['status' => Subscription::INACTIVE]);

            $transaction = Transaction::create([
                'tenant_id' => $subscription->tenant_id,
                'transaction_id' => $input['payment_id'],
                'type' => Subscription::MERCADO_PAGO,
                'amount' => $amount,
                'status' => Subscription::ACTIVE,
                'meta' => json_encode($input),
            ]);

            $subscription->update(['transaction_id' => $transaction->id]);

            $affiliateAmount = getSuperAdminSettingValue('affiliation_amount');
            $affiliateAmountType = getSuperAdminSettingValue('affiliation_amount_type');

            if ($affiliateAmountType == 1) {
                AffiliateUser::whereUserId($user->id)->where('amount', 0)->withoutGlobalScopes()
                    ->update(['amount' => $affiliateAmount, 'is_verified' => 1]);
            } elseif ($affiliateAmountType == 2) {
                $amountAffiliate = $amount * $affiliateAmount / 100;
                AffiliateUser::whereUserId($user->id)->where('amount', 0)->withoutGlobalScopes()
                    ->update(['amount' => $amountAffiliate, 'is_verified' => 1]);
            }

            $emailData = [
                'subscriptionID' => $subscriptionId,
                'amountToPay' => $amount,
                'planName' => $subscription->plan->name,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ];

            manageVcards($user);
            Mail::to($user->email)->send(new SubscriptionPaymentSuccessMail($emailData));

            DB::commit();

            return $this->sendResponse([
                'subscription_id' => $subscriptionId,
                'transaction_id' => $transaction->id,
                'plan_name' => $subscription->plan->name,
                'amount' => $amount,
                'status' => 'active',
            ], 'Payment completed successfully.');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('MercadoPago paymentSuccess error: ' . $e->getMessage());
            return $this->sendError('Payment processing failed: ' . $e->getMessage(), 500);
        }
    }
}
