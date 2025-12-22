<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Carbon\Carbon;
use Stripe\Stripe;
use App\Models\Plan;
use App\Models\CouponCode;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use App\Models\AffiliateUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\ApiErrorException;
use App\Http\Controllers\AppBaseController;
use App\Mail\SubscriptionPaymentSuccessMail;
use App\Repositories\SubscriptionRepository;
use Stripe\Exception\AuthenticationException;

class StripeAPIController extends AppBaseController
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
        $stripeKey = getSelectedPaymentGateway('stripe_key');
        $stripeSecret = getSelectedPaymentGateway('stripe_secret');

        if (empty($stripeSecret) || empty($stripeKey)) {
            return $this->sendError('Stripe credentials is not set');
        }

        try {
            Stripe::setApiKey($stripeSecret);

            $sessionData = [
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => strtolower($subscription->plan->currency->currency_code),
                        'product_data' => [
                            'name' => $subscription->plan->name,
                            'description' => 'Subscribing for the plan named ' . $subscription->plan->name,
                        ],
                        'unit_amount' => $data['amountToPay'] * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.cancel'),
                'client_reference_id' => $subscription->id,
                'customer_email' => Auth::user()->email,
                'metadata' => [
                    'subscription_id' => $subscription->id,
                    'amount' => $data['amountToPay'],
                    'user_id' => Auth::id(),
                    'plan_id' => $plan->id,
                ],
            ];

            $session = Session::create($sessionData);

            $responseData = [
                'sessionId' => $session->id,
                'sessionUrl' => $session->url,
                'successUrl' => $session->success_url,
                'amount' => $data['amountToPay'],
                'name' => Auth::user()->full_name,
                'email' => Auth::user()->email,
                'contact' => Auth::user()->contact,
                'subscription' => $subscription,
                'stripePublicKey' => $stripeKey,
            ];

            return $this->sendResponse($responseData, 'Stripe session generated successfully.');

        } catch (AuthenticationException $e) {
            return $this->sendError('Payment gateway authentication failed.', 500);

        } catch (ApiErrorException $e) {
            return $this->sendError('Payment gateway error. Please try again later.', 500);

        } catch (Exception $e) {
            return $this->sendError('Failed to create Stripe checkout session. Please try again later.', 500);
        }
    }

    public function paymentSuccess(Request $request): JsonResponse
    {
        $user = Auth::user();
        if ($user->email == 'admin@vcard.com') {
            return $this->sendError('Seems, you are not allowed to access this record.', 403);
        }

        $sessionId = $request->input('session_id');

        if (empty($sessionId)) {
            return $this->sendError('Session ID is required.', 400);
        }

        $stripeSecret = getSelectedPaymentGateway('stripe_secret');

        if (empty($stripeSecret)) {
            return $this->sendError('Stripe credentials is not set');
        }

        try {
            Stripe::setApiKey($stripeSecret);
            $session = Session::retrieve($sessionId);

            if (!$session || $session->payment_status !== 'paid') {
                return $this->sendError('Payment verification failed.', 400);
            }

            $subscriptionID = $session->metadata->subscription_id;
            $amountToPay = $session->metadata->amount;

            $subscription = Subscription::findOrFail($subscriptionID);

            Subscription::findOrFail($subscriptionID)->update([
                'payment_type' => Subscription::STRIPE,
                'status' => Subscription::ACTIVE
            ]);

            // De-Active all other subscriptions
            Subscription::whereTenantId(getLogInTenantId())
                ->where('id', '!=', $subscriptionID)
                ->where('status', '!=', Subscription::REJECT)
                ->update([
                    'status' => Subscription::INACTIVE,
                ]);

            // Create Transaction
            $transaction = Transaction::create([
                'tenant_id' => $subscription->tenant_id,
                'transaction_id' => $session->payment_intent,
                'type' => Subscription::STRIPE,
                'amount' => $amountToPay,
                'status' => Subscription::ACTIVE,
                'meta' => json_encode($session->toArray()),
            ]);

            $subscription = Subscription::findOrFail($subscriptionID);
            $planName = $subscription->plan->name;
            $subscription->update([
                'transaction_id' => $transaction->id,
                'payment_type' => Subscription::STRIPE
            ]);

            // Handle affiliate amounts
            $affiliateAmount = getSuperAdminSettingValue('affiliation_amount');
            $affiliateAmountType = getSuperAdminSettingValue('affiliation_amount_type');

            if ($affiliateAmountType == 1) {
                AffiliateUser::whereUserId(getLogInUserId())
                    ->where('amount', 0)
                    ->withoutGlobalScopes()
                    ->update([
                        'amount' => $affiliateAmount,
                        'is_verified' => 1
                    ]);
            } else if ($affiliateAmountType == 2) {
                $amount = $amountToPay * $affiliateAmount / 100;
                AffiliateUser::whereUserId(getLogInUserId())
                    ->where('amount', 0)
                    ->withoutGlobalScopes()
                    ->update([
                        'amount' => $amount,
                        'is_verified' => 1
                    ]);
            }

            $userEmail = getLogInUser()->email;
            $firstName = getLogInUser()->first_name;
            $lastName = getLogInUser()->last_name;
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
            Log::error('Stripe Payment Error: ' . $e->getMessage());
            return $this->sendError('Payment processing failed: ' . $e->getMessage(), 500);
        }
    }

    public function paymentCancel(): JsonResponse
    {
        return $this->sendError('Payment was cancelled by the user.', 400);
    }
}
