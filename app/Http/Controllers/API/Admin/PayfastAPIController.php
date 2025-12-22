<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\CouponCode;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\AffiliateUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AppBaseController;
use App\Mail\SubscriptionPaymentSuccessMail;
use App\Repositories\SubscriptionRepository;

class PayFastAPIController extends AppBaseController
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

        if ($plan->currency->currency_code !== "ZAR") {
            return $this->sendError('PayFast requires the ZAR currency.');
        }

        if ($plan->custom_select == 1) {
            if (empty($customFieldId)) {
                return $this->sendError('Please select a custom option for this plan.');
            }
            $validCustomField = $plan->planCustomFields()->where('id', $customFieldId)->exists();
            if (!$validCustomField) {
                return $this->sendError('Invalid custom field selection for this plan.');
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

        $currency = $subscription->plan->currency->currency_code;
        if ($currency !== "ZAR") {
            return $this->sendError('PayFast requires the ZAR currency.');
        }

        $merchant_id = getSelectedPaymentGateway('payfast_merchant_id');
        $merchant_key = getSelectedPaymentGateway('payfast_merchant_key');
        $passphrase = getSelectedPaymentGateway('payfast_passphrase_key');
        $sandbox = getSelectedPaymentGateway('payfast_mode') == 'sandbox';

        if (empty($merchant_id) || empty($merchant_key)) {
            return $this->sendError('PayFast credentials are not set.');
        }

        $amount = number_format($data['amountToPay'], 2, '.', '');
        $reference = 'sub_' . uniqid();
        $data['m_payment_id'] = $reference;

        /** -------------------------------------------
         *  ✔ FIX ADDED: custom_int1 = subscription ID
         *  PayFast notify માં subscription મળી રહે
         * ------------------------------------------- */
        $payfastData = [
            'merchant_id' => $merchant_id,
            'merchant_key' => $merchant_key,
            'return_url' => route('payfast.success', $data),
            'cancel_url' => route('payfast.cancel', $data),

            // MUST BE CLEAN URL – NO QUERY PARAMS
            'notify_url'   => config('app.url') . '/api/admin/payfast-payment-notify',
            'name_first' => Auth::user()->first_name ?? '',
            'email_address' => Auth::user()->email ?? '',
            'm_payment_id' => $reference,
            'amount' => $amount,
            'item_name' => 'Subscription Plan - ' . $subscription->plan->name,
            // 🚀 MAIN FIX
            'custom_int1'   => $subscription->id,
        ];

        // Generate Signature
        $queryString = http_build_query($payfastData);
        if (!empty($passphrase)) {
            $queryString .= '&passphrase=' . urlencode($passphrase);
        }
        $signature = md5($queryString);
        $payfastData['signature'] = $signature;

        $baseUrl = $sandbox
            ? 'https://sandbox.payfast.co.za/eng/process'
            : 'https://www.payfast.co.za/eng/process';

        $checkoutUrl = $baseUrl . '?' . http_build_query($payfastData);

        return $this->sendResponse([
            'plan_id' => $plan->id,
            'subscription_id'=> $subscription->id,
            'payment_type'  => 'payfast',
            'checkout_url' => $checkoutUrl,
            'signature' => $signature,
            'amount'  => $amount,
            'currency' => "ZAR",
            'reference'  => $reference,
            'payload' => $payfastData,
            'query_string' => $queryString,
        ], 'PayFast checkout session created successfully.');
    }

    public function paymentSuccess(Request $request): JsonResponse
    {
        $subscriptionID = $request->input('subscription_id');
        $amount = $request->input('amount');
        $reference = $request->input('reference');

        $subscription = Subscription::findOrFail($subscriptionID);

        $subscription->update([
            'payment_type' => Subscription::PAYFAST,
            'status' => Subscription::ACTIVE
        ]);

        Subscription::where('tenant_id', $subscription->tenant_id)
            ->where('id', '!=', $subscriptionID)
            ->where('status', '!=', Subscription::REJECT)
            ->update(['status' => Subscription::INACTIVE]);

        $transaction = Transaction::create([
            'tenant_id' => $subscription->tenant_id,
            'transaction_id' => $reference,
            'type' => Subscription::PAYFAST,
            'amount' => $amount,
            'status' => Subscription::ACTIVE,
            'meta' => json_encode($request->all()),
        ]);

        $subscription->update(['transaction_id' => $transaction->id, 'payment_type' => Subscription::PAYFAST]);

        // Affiliate logic
        $affiliateAmount = getSuperAdminSettingValue('affiliation_amount');
        $affiliateAmountType = getSuperAdminSettingValue('affiliation_amount_type');
        $user = $subscription->tenant->user;

        if ($affiliateAmountType == 1) {
            AffiliateUser::where('user_id', $user->id)
                ->where('amount', 0)
                ->withoutGlobalScopes()
                ->update(['amount' => $affiliateAmount, 'is_verified' => 1]);
        } else if ($affiliateAmountType == 2) {
            $commission = $amount * $affiliateAmount / 100;
            AffiliateUser::where('user_id', $user->id)
                ->where('amount', 0)
                ->withoutGlobalScopes()
                ->update(['amount' => $commission, 'is_verified' => 1]);
        }

        $userEmail = getLogInUser()->email;
        $firstName = getLogInUser()->first_name;
        $lastName = getLogInUser()->last_name;
        $emailData = [
            'subscriptionID' => $subscriptionID,
            'amountToPay' => $amount,
            'planName' => $subscription->plan->name,
            'first_name' => $firstName,
            'last_name' => $lastName,
        ];

        manageVcards();
        Mail::to($userEmail)->send(new SubscriptionPaymentSuccessMail($emailData));

        return $this->sendResponse([
            'subscription_id' => $subscriptionID,
            'transaction_id' => $transaction->id,
            'plan_name' => $subscription->plan->name,
            'amount' => $amount,
            'status' => 'active'
        ], 'Payment completed successfully.');
    }

    // public function paymentSuccess(Request $request): JsonResponse
    // {
    //     $subscriptionID = $request->subscription; // URL: ?subscription=XXX
    //     $amount = $request->amountToPay;
    //     $reference = $request->m_payment_id;

    //     if (!$subscriptionID) {
    //         return $this->sendError('Subscription not found');
    //     }

    //     $subscription = Subscription::find($subscriptionID);

    //     if (!$subscription) {
    //         return $this->sendError('Subscription not found');
    //     }

    //     // Activate subscription directly (WITHOUT NOTIFY)
    //     $subscription->update([
    //         'payment_type' => Subscription::PAYFAST,
    //         'status' => Subscription::ACTIVE,
    //         'transaction_id' => $reference,
    //     ]);

    //     // Mark older subscriptions inactive
    //     Subscription::where('tenant_id', $subscription->tenant_id)
    //         ->where('id', '!=', $subscriptionID)
    //         ->update(['status' => Subscription::INACTIVE]);

    //     // Create transaction record
    //     Transaction::create([
    //         'tenant_id' => $subscription->tenant_id,
    //         'transaction_id' => $reference,
    //         'type' => Subscription::PAYFAST,
    //         'amount' => $amount,
    //         'status' => Subscription::ACTIVE,
    //         'meta' => 'Success URL auto-activated'
    //     ]);

    //     return $this->sendSuccess('Payment success (notify bypass)');
    // }


    public function paymentCancel(Request $request): JsonResponse
    {
        $subscriptionID = $request->input('subscription_id');
        Subscription::findOrFail($subscriptionID)->delete();

        return $this->sendError('Payment was cancelled by the user.', 400);
    }

    public function notify(Request $request): JsonResponse
    {

        $input = $request->all();

            Log::info('PayFast RAW Notify Payload', $input);

        // Step 1: Rebuild signature string correctly (skip 'signature')
        $pfSignatureString = '';
        foreach ($input as $key => $val) {
            if ($key !== 'signature' && $val !== '' && $val !== null) {
                $pfSignatureString .= $key . '=' . $val . '&';
            }
        }
        $pfSignatureString = rtrim($pfSignatureString, '&');

        $passphrase = getSelectedPaymentGateway('payfast_passphrase_key');
        if (!empty($passphrase)) {
            $pfSignatureString .= '&passphrase=' . $passphrase;
        }
        $calculatedSignature = md5($pfSignatureString);

        // Step 2: Verify signature (case-insensitive compare)
        if (strtolower($input['signature'] ?? '') !== strtolower($calculatedSignature)) {
            Log::error('PayFast notify signature mismatch', [
                'input' => $input,
                'expected' => $calculatedSignature
            ]);
            return $this->sendError('Invalid signature', 400);
        }

        // Step 3: Validate notify with PayFast server
        $host = getSelectedPaymentGateway('payfast_mode') == 'sandbox'
            ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';

        $opts = [
            "http" => [
                "method" => "POST",
                "header" => "Content-type: application/x-www-form-urlencoded",
                "content" => http_build_query($input),
                "timeout" => 10,
            ]
        ];
        $context = stream_context_create($opts);
        $validationResponse = file_get_contents("https://$host/eng/query/validate", false, $context);

        if ($validationResponse !== 'VALID') {
            Log::error('PayFast notify validation failed', [
                'response' => $validationResponse,
                'input' => $input
            ]);
            return $this->sendError('Invalid notify validation', 400);
        }

        // Step 4: Process payment safely only after validation

        $subscriptionID = $input['subscription'] ?? $input['subscription_id'] ?? null;
        $amount = $input['amount_gross'] ?? $input['amount'] ?? null;
        $reference = $input['m_payment_id'] ?? null;

        if (!$subscriptionID || !$amount || !$reference) {
            Log::error('PayFast notify missing essential data', ['input' => $input]);
            return $this->sendError('Missing data', 400);
        }

        $subscription = Subscription::with(['tenant.user', 'plan'])->find($subscriptionID);
        if (!$subscription) {
            Log::error('PayFast notify subscription not found', ['subscription_id' => $subscriptionID]);
            return $this->sendError('Subscription not found', 400);
        }

        $subscription->update([
            'payment_type' => Subscription::PAYFAST,
            'status' => Subscription::ACTIVE,
            'transaction_id' => $reference,
        ]);

        Subscription::where('tenant_id', $subscription->tenant_id)
            ->where('id', '!=', $subscriptionID)
            ->where('status', '!=', Subscription::REJECT)
            ->update(['status' => Subscription::INACTIVE]);

        $transaction = Transaction::create([
            'tenant_id' => $subscription->tenant_id,
            'transaction_id' => $reference,
            'type' => Subscription::PAYFAST,
            'amount' => $amount,
            'status' => Subscription::ACTIVE,
            'meta' => json_encode($input),
        ]);

        $subscription->update(['transaction_id' => $transaction->id]);

        // Affiliate updates - same logic as your paymentSuccess method
        $affiliateAmount = getSuperAdminSettingValue('affiliation_amount');
        $affiliateAmountType = getSuperAdminSettingValue('affiliation_amount_type');
        $user = $subscription->tenant->user;

        if ($affiliateAmountType == 1) {
            AffiliateUser::where('user_id', $user->id)
                ->where('amount', 0)
                ->withoutGlobalScopes()
                ->update([
                    'amount' => $affiliateAmount,
                    'is_verified' => 1,
                ]);
        } else if ($affiliateAmountType == 2) {
            $commission = $amount * $affiliateAmount / 100;
            AffiliateUser::where('user_id', $user->id)
                ->where('amount', 0)
                ->withoutGlobalScopes()
                ->update([
                    'amount' => $commission,
                    'is_verified' => 1,
                ]);
        }

        try {
            $emailData = [
                'subscriptionID' => $subscriptionID,
                'amountToPay' => $amount,
                'planName' => $subscription->plan->name,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ];
            Mail::to($user->email)->send(new SubscriptionPaymentSuccessMail($emailData));
        } catch (Exception $e) {
            Log::error('PayFast notify mail error', ['error' => $e->getMessage()]);
        }

        if (function_exists('manageVcards')) {
            manageVcards();
        }

        // Must respond with 200 status and body “OK” to tell PayFast we processed successfully
        return $this->sendSuccess('OK');
    }

}
