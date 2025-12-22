<?php

namespace App\Http\Controllers\API\Admin;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\CouponCode;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppBaseController;
use App\Repositories\SubscriptionRepository;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalAPIController extends AppBaseController
{
    private SubscriptionRepository $subscriptionRepository;

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

        $plan = Plan::with('currency')->findOrFail($planId);

        if ($plan->currency->currency_code != null && ! in_array(
                strtoupper($plan->currency->currency_code),
                getPayPalSupportedCurrencies()
            )) {
                return $this->sendError(__('messages.placeholder.this_currency_is_not_supported'));
        }

        //Custom field validation
        if ($plan->custom_select == 1) {
            if (empty($customFieldId)) {
                return $this->sendError('Please select a custom option for this plan.');
            }

            $validCustomField = $plan->planCustomFields()->where('id', $customFieldId)->exists();
            if (!$validCustomField) {
                return $this->sendError('Invalid custom field selection for this plan.');
            }
        } elseif (!empty($customFieldId)) {
            return $this->sendError('This plan does not have custom options.');
        }

        // Coupon Validation
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


        $current = getCurrentSubscription();
        if ($current && $current->plan_id == $planId &&
            Carbon::parse($current->ends_at)->gt(Carbon::now())) {

            return $this->sendError('You already have this active subscription plan.');
        }

        //CREATE SUBSCRIPTION
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

        // Free plan handling
        if (empty($data['amountToPay']) || $data['amountToPay'] == 0) {
            return $this->sendResponse([
                'plan' => $plan
            ], 'Plan activated successfully (Free Plan).');
        }

        //PAYPAL CONFIG
        $mode = getSelectedPaymentGateway('paypal_mode'); // sandbox/live
        $clientId = getSelectedPaymentGateway('paypal_client_id');
        $clientSecret = getSelectedPaymentGateway('paypal_secret');

        config([
            'paypal.mode' => $mode,
            'paypal.sandbox.client_id' => $clientId,
            'paypal.sandbox.client_secret' => $clientSecret,
            'paypal.live.client_id' => $clientId,
            'paypal.live.client_secret' => $clientSecret,
        ]);

        $provider = new PayPalClient();
        $provider->getAccessToken();

        //CALLBACK URLs
        $successUrl = route('paypal.subscription.success');
        $cancelUrl  = route('paypal.subscription.failed');

        //PAYPAL ORDER PAYLOAD (FIXED)
        $paypalOrder = [
            'intent' => 'CAPTURE',
            'application_context' => [
                'brand_name' => 'Vcards SaaS',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW',
                'return_url' => $successUrl,
                'cancel_url' => $cancelUrl,
            ],
            'purchase_units' => [
                [
                    'reference_id' => (string)$subscription->id,
                    'description' => "Subscription Payment",
                    'amount' => [
                        'currency_code' => $plan->currency->currency_code,
                        'value' => $data['amountToPay'],
                    ]
                ],
            ],
        ];

        $order = $provider->createOrder($paypalOrder);

        if (!isset($order['links'][1]['href'])) {
            return $this->sendError('Unable to create PayPal payment session.', 400);
        }

        $checkoutUrl = $order['links'][1]['href'];

        //Extract Token from checkout URL
        $token = null;
        parse_str(parse_url($checkoutUrl, PHP_URL_QUERY), $queryData);
        if (isset($queryData['token'])) {
            $token = $queryData['token'];
        }

        //Final Response
        return $this->sendResponse([
            'plan_id' => $plan->id,
            'subscription_id' => $subscription->id,
            'payment_type' => 'paypal',
            'checkout_url' => $checkoutUrl,
            'token' => $token,
            'amount' => $data['amountToPay'],
            'currency' => $plan->currency->currency_code,
        ], 'PayPal checkout session created successfully.');
    }

    public function paymentSuccess(Request $request): JsonResponse
    {
        try {
            $mode = getSelectedPaymentGateway('paypal_mode');
            $clientId = getSelectedPaymentGateway('paypal_client_id');
            $clientSecret = getSelectedPaymentGateway('paypal_secret');

            if (empty($clientId) || empty($clientSecret)) {
                Log::error('PayPal credentials missing in paymentSuccess', [
                    'clientId_present' => !empty($clientId),
                    'clientSecret_present' => !empty($clientSecret),
                ]);
                return $this->sendError('PayPal credentials not configured.', 500);
            }

            config([
                'paypal.mode' => $mode,
                'paypal.sandbox.client_id' => $clientId,
                'paypal.sandbox.client_secret' => $clientSecret,
                'paypal.live.client_id' => $clientId,
                'paypal.live.client_secret' => $clientSecret,
            ]);

            $token = $request->get('token');
            $payerId = $request->get('PayerID');

            if (!$token) {
                return $this->sendError('Invalid token.', 400);
            }

            $provider = new PayPalClient();
            $provider->getAccessToken();

            $order = $provider->capturePaymentOrder($token);

            Log::info("PAYPAL CAPTURE RESPONSE", ['order' => $order]);

            if (!isset($order['status']) || strtoupper($order['status']) !== 'COMPLETED') {
                return $this->sendError('Payment not completed.', 400);
            }

            $subscriptionId = $order['purchase_units'][0]['reference_id'];
            if (!$subscriptionId) {
                Log::error('PayPal capture: missing reference_id (subscription id)', ['order' => $order]);
                return $this->sendError('Subscription reference missing in PayPal response.', 500);
            }

            $subscription = Subscription::findOrFail($subscriptionId);
            $subscription->update([
                'payment_type' => Subscription::PAYPAL,
                'status' => Subscription::ACTIVE,
            ]);

            // Deactivate old subscriptions
            Subscription::whereTenantId(getLogInTenantId())
                ->where('id', '!=', $subscriptionId)
                ->where('status', '!=', Subscription::REJECT)
                ->update(['status' => Subscription::INACTIVE]);

            // Save Transaction
            Transaction::create([
                'tenant_id' => $subscription->tenant_id,
                'transaction_id' => $order['id'],
                'type' => Subscription::PAYPAL,
                'amount' => $order['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                'status' => Subscription::ACTIVE,
                'meta' => json_encode($order),
            ]);

            return $this->sendResponse([
                'subscription_id' => $subscriptionId,
                'transaction_id' => $order['id'],
                'status' => 'active'
            ], 'Payment completed successfully.');

        } catch (\Throwable $e) {
            Log::error('PAYPAL PAYMENT ERROR', ['error' => $e->getMessage()]);
            return $this->sendError($e->getMessage(), 500);
        }
    }

    public function paymentFailed(Request $request): JsonResponse
    {
        $token = $request->get('token');

        return $this->sendError('You cancelled the payment or it failed.');
    }
}
