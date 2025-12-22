<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use Razorpay\Api\Api;
use App\Models\CouponCode;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\AffiliateUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AppBaseController;
use App\Mail\SubscriptionPaymentSuccessMail;
use App\Repositories\SubscriptionRepository;

class RazorpayAPIController extends AppBaseController
{
    private $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function onBoard(Request $request): JsonResponse
    {
        $planId = $request->input('planId');
        $customFieldId = $request->input('customFieldId');
        $couponCodeId = $request->input('couponCodeId');
        $couponCode = $request->input('couponCode');


        $plan = Plan::findOrFail($planId);

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

        $subscription = $data['subscription'];
        $razorpayKey = getSelectedPaymentGateway('razorpay_key');
        $razorpaySecret = getSelectedPaymentGateway('razorpay_secret');
        if (empty($razorpaySecret) || empty($razorpayKey)) {
            return $this->sendError('Razorpay credentials is not set');
        }
        $api = new Api($razorpayKey, $razorpaySecret);
        $orderData = [
            'receipt' => 1,
            'amount' => $data['amountToPay'] * 100,
            'currency' => $subscription->plan->currency->currency_code,
            'notes' => [
                'email' => Auth::user()->email,
                'name' => Auth::user()->full_name,
                'subscriptionId' => $subscription->id,
                'amountToPay' => $data['amountToPay'],
            ],
        ];
        $razorpayOrder = $api->order->create($orderData);
        $data['id'] = $razorpayOrder->id;
        $data['amount'] = $data['amountToPay'];
        $data['name'] = Auth::user()->full_name;
        $data['email'] = Auth::user()->email;
        $data['contact'] = Auth::user()->contact;
        return $this->sendResponse($data, 'Razorpay session generated successfully.');
    }

    /**
     * @return JsonResponse
     */
    public function paymentSuccess(Request $request): JsonResponse
    {
        $user = Auth::user();
        if($user->email == 'admin@vcard.com'){
            return $this->sendError('Seems, you are not allowed to access this record.', 403);
        }

        $input = $request->all();

        Log::info('RazorPay Payment Successfully');
        Log::info($input);
        $razorpayKey = getSelectedPaymentGateway('razorpay_key');
        $razorpaySecret = getSelectedPaymentGateway('razorpay_secret');

        if (empty($razorpaySecret) || empty($razorpayKey)) {
            return $this->sendError('Razorpay credentials is not set');
        }
        $api = new Api($razorpayKey, $razorpaySecret);

        if (count($input) && ! empty($input['razorpay_payment_id'])) {
            try {
                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                // $generatedSignature = hash_hmac(
                //     'sha256',
                //     $payment['order_id'] . '|' . $input['razorpay_payment_id'],
                //     getSelectedPaymentGateway('razorpay_secret')
                // );

                // if ($generatedSignature != $input['razorpay_signature']) {
                //     return $this->sendError('Payment verification failed.', 400);
                // }

                // Create Transaction Here
                $subscriptionID = $payment['notes']['subscriptionId'];
                $amountToPay = $payment['notes']['amountToPay'];
                $subscription = Subscription::findOrFail($subscriptionID);

                Subscription::findOrFail($subscriptionID)->update([
                    'payment_type' => Subscription::RAZORPAY,
                    'status' => Subscription::ACTIVE
                ]);

                // De-Active all other subscription
                Subscription::whereTenantId(getLogInTenantId())
                    ->where('id', '!=', $subscriptionID)
                    ->where('status', '!=', Subscription::REJECT)
                    ->update([
                        'status' => Subscription::INACTIVE,
                    ]);

                $transaction = Transaction::create([
                    'tenant_id' => $subscription->tenant_id,
                    'transaction_id' => $payment->id,
                    'type' => Subscription::RAZORPAY,
                    'amount' => $amountToPay,
                    'status' => Subscription::ACTIVE,
                    'meta' => json_encode($payment->toArray()),
                ]);

                $subscription = Subscription::findOrFail($subscriptionID);
                $planName = $subscription->plan->name;
                $subscription->update(['transaction_id' => $transaction->id, 'payment_type' => Subscription::RAZORPAY]);

                $affiliateAmount = getSuperAdminSettingValue('affiliation_amount');
                $affiliateAmountType = getSuperAdminSettingValue('affiliation_amount_type');
                if ($affiliateAmountType == 1) {
                    AffiliateUser::whereUserId(getLogInUserId())->where('amount', 0)->withoutGlobalScopes()->update(['amount' => $affiliateAmount, 'is_verified' => 1]);
                } else if ($affiliateAmountType == 2) {
                    $amount = $amountToPay * $affiliateAmount / 100;
                    AffiliateUser::whereUserId(getLogInUserId())->where('amount', 0)->withoutGlobalScopes()->update(['amount' => $amount, 'is_verified' => 1]);
                }

                $userEmail = getLogInUser()->email;
                $firstName = getLogInUser()->first_name;
                $lastName =  getLogInUser()->last_name;
                $emailData = [
                    'subscriptionID' => $subscriptionID,
                    'amountToPay' => $amountToPay,
                    'planName' => $planName,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ];

                manageVcards();
                Mail::to($userEmail)->send(new SubscriptionPaymentSuccessMail($emailData));

                $responseData = [
                    'subscription_id' => $subscriptionID,
                    'transaction_id' => $transaction->id,
                    'plan_name' => $planName,
                    'amount' => $amountToPay,
                    'status' => 'active'
                ];

                return $this->sendResponse($responseData, 'Payment completed successfully.');

            } catch (Exception $e) {
                Log::error('Payment Error: ' . $e->getMessage());
                return $this->sendError('Payment processing failed.', 500);
            }
        }
        return $this->sendError('Invalid payment data.', 400);
    }
}
