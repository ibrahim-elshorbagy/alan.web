@extends('layouts.app')
@section('title')
    {{ __('messages.subscription.payment') }}
@endsection
@section('content')
    @php

        if ($customField) {
            $subcriptionPrice = $customField->custom_vcard_price;
        } else {
            $subcriptionPrice = $subscriptionsPricingPlan->price;
        }

    @endphp
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-end mb-5">
                    <h1>@yield('title')</h1>
                    <a class="btn btn-outline-primary float-end"
                        href="{{ url()->previous() }}">{{ __('messages.common.back') }}</a>
                </div>

                <div class="col-12">
                    @include('flash::message')
                </div>
                <div class="card">
                    @php
                        $cpData = getCurrentPlanDetails();
                        $planText = $cpData['isExpired']
                            ? __('messages.subscription.current_expire')
                            : __('messages.subscription.current_plan');
                        $currentPlan = $cpData['currentPlan'];
                    @endphp
                    <div class="card-body">
                        <div class="row">
                            @if ($planText != 'Current Expired Plan')
                                <div class="col-md-6">
                                    <div class="card p-5 me-2 shadow rounded">
                                        <div class="card-header py-0 px-0">
                                            <h3 class="align-items-start flex-column p-sm-5 p-0">
                                                <span
                                                    class="fw-bolder text-primary fs-1 mb-1 me-0">{{ $planText }}</span>
                                            </h3>
                                        </div>
                                        <div class="px-4">
                                            <div class="d-flex align-items-center py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 fw-bolder">
                                                    {{ __('messages.subscription.plan_name') }}</h4>
                                                <span class="fs-5 w-50 text-muted fw-bold mt-1">{{ $cpData['name'] }}</span>
                                            </div>
                                            <div class="d-flex align-items-center  py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-3 fw-bolder">
                                                    {{ __('messages.subscription.plan_price') }}</h4>
                                                <span class="fs-5 text-muted fw-bold mt-1">
                                                    <span class="mb-2">
                                                        {{ getCurrencyAmount($currentPlan->price, $currentPlan->currency->currency_icon) }}
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center  py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 fw-bolder">
                                                    {{ __('messages.subscription.start_date') }}</h4>
                                                <span
                                                    class="fs-5 w-50 text-muted fw-bold mt-1">{{ localized_date($cpData['startAt'], 'jS F, Y') }}</span>
                                            </div>
                                            <div class="d-flex align-items-center  py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 fw-bolder">
                                                    {{ __('messages.subscription.end_date') }}</h4>
                                                <span
                                                    class="fs-5 w-50 text-muted fw-bold mt-1">{{ localized_date($cpData['endsAt'], 'jS F, Y') }}</span>
                                            </div>
                                            <div class="d-flex align-items-center  py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 fw-bolder">
                                                    {{ __('messages.subscription.used_days') }}</h4>
                                                <span class="fs-5 w-50 text-muted fw-bold mt-1">{{ $cpData['usedDays'] }}
                                                    {{ __('messages.plan.days') }}</span>
                                            </div>
                                            <div class="d-flex align-items-center  py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 fw-bolder">
                                                    {{ __('messages.subscription.remaining_days') }}</h4>
                                                <span
                                                    class="fs-5 w-50 text-muted fw-bold mt-1">{{ $cpData['remainingDays'] }}
                                                    {{ __('messages.plan.days') }}</span>
                                            </div>
                                            <div class="d-flex align-items-center  py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 fw-bolder">
                                                    {{ __('messages.subscription.used_balance') }}</h4>
                                                <span class="fs-5 w-50 text-muted fw-bold mt-1">
                                                    <span class="mb-2">
                                                        {{ getCurrencyAmount($cpData['usedBalance'], $currentPlan->currency->currency_icon) }}
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center  py-2">
                                                <h4 class="fs-5 w-50 mb-0 me-5 fw-bolder">
                                                    {{ __('messages.subscription.remaining_balance') }}</h4>
                                                <span class="fs-5 w-50 text-muted fw-bold mt-1">
                                                    <span class="mb-2">
                                                        {{ getCurrencyAmount($cpData['remainingBalance'], $currentPlan->currency->currency_icon) }}
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @php
                                $newPlan = getProratedPlanData($subscriptionsPricingPlan->id);
                            @endphp

                            {{ Form::hidden('amount_to_pay', $newPlan['amountToPay'], ['id' => 'amountToPay']) }}
                            {{ Form::hidden('plan_end_date', $newPlan['endDate'], ['id' => 'planEndDate']) }}
                            <div class="col-md-6 col-12 @if ($planText == 'Current Expired Plan') mx-auto @endif">
                                <div class="card h-100 p-5 me-2 shadow rounded">
                                    <div class="card-header py-0 px-0">
                                        <h3 class="align-items-start flex-column p-sm-5 p-0">
                                            <span
                                                class="fw-bolder text-primary fs-1 mb-1 me-0">{{ __('messages.plan.new_plan') }}</span>
                                            @if ($newPlan['trialDays'] > 0)
                                                <span id="trialPlanBtn"
                                                    class="badge bg-light-warning text-lg py-2 px-3 ms-4">{{ __('messages.subscription.trial_plan') }}
                                                </span>
                                            @endif
                                        </h3>
                                    </div>
                                    <div class="px-5 pb-5">
                                        <div class="d-flex align-items-center py-2">
                                            <h4 class="fs-5 w-50 plan-data mb-0 me-5 fw-bolder">
                                                {{ __('messages.subscription.plan_name') }}</h4>
                                            <span class="fs-5 w-50 text-muted fw-bold mt-1">{{ $newPlan['name'] }}</span>
                                        </div>
                                        <div class="d-flex align-items-center py-2">
                                            <h4 class="fs-5 w-50 plan-data mb-0 me-5 fw-bolder">
                                                {{ __('messages.subscription.plan_price') }}</h4>
                                            <span class="fs-5 w-50 text-muted fw-bold mt-1">
                                                <span class="mb-2">
                                                    {{ getCurrencyAmount($subcriptionPrice, $subscriptionsPricingPlan->currency->currency_icon) }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center  py-2">
                                            <h4 class="fs-5 w-50 plan-data mb-0 me-5 fw-bolder">
                                                {{ __('messages.subscription.start_date') }}</h4>
                                            <span
                                                class="fs-5 w-50 text-muted fw-bold mt-1">{{ localized_date($newPlan['startDate'], 'jS F, Y') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center  py-2">
                                            <h4 class="fs-5 w-50 plan-data mb-0 me-5 fw-bolder">
                                                {{ __('messages.subscription.end_date') }}</h4>
                                            <span
                                                class="fs-5 w-50 text-muted fw-bold mt-1">{{ localized_date($newPlan['endDate'], 'jS F, Y') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center  py-2">
                                            <h4 class="fs-5 w-50 plan-data mb-0 me-5 fw-bolder">
                                                {{ __('messages.subscription.total_days') }}</h4>
                                            <span class="fs-5 w-50 text-muted fw-bold mt-1">{{ $newPlan['totalDays'] }}
                                                {{ __('messages.plan.days') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center py-2 d-none">
                                            <h4 class="fs-5 w-50 plan-data mb-0 me-5 fw-bolder">
                                                {{ __('messages.coupon_code.coupon_discount') }}</h4>
                                            <span class="fs-5 w-50 text-muted fw-bold mt-1">
                                                <span
                                                    class="coupon-discount">{{ getCurrencyAmount($subcriptionPrice, $subscriptionsPricingPlan->currency->currency_icon) }}</span>
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center  py-2">
                                            <h4 class="fs-5 w-50 plan-data mb-0 me-5 fw-bolder">
                                                {{ __('messages.plan.remaining_balance') }}</h4>
                                            <span class="fs-5 w-50 text-muted fw-bold mt-1">
                                                {{ getCurrencyAmount($newPlan['remainingBalance'], $subscriptionsPricingPlan->currency->currency_icon) }}
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center  py-2">
                                            <h4 class="fs-5 w-50 plan-data mb-0 me-5 fw-bolder">
                                                {{ __('messages.subscription.payable_amount') }}</h4>
                                            <span class="fs-5 w-50 text-muted fw-bold mt-1">
                                                @php
                                                    if ($customField) {
                                                        $amountTopay =
                                                            $customField->custom_vcard_price -
                                                            $cpData['remainingBalance'];
                                                    } else {
                                                        $amountTopay = $newPlan['amountToPay'];
                                                    }

                                                    if ($amountTopay < 0) {
                                                        $amountTopay = 0;
                                                    }
                                                @endphp
                                                <span
                                                    class="payable-amount">{{ getCurrencyAmount($amountTopay, $subscriptionsPricingPlan->currency->currency_icon) }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-danger d-none mt-2 mx-1" id="manualPaymentValidationErrorsBox"></div>
                        <div class="card mt-10 p-0 pt-0">
                            <div class="">
                                <h1 class="fs-14h mb-5 {{ $newPlan['amountToPay'] <= 0 ? 'd-none' : '' }}">
                                    {{ __('messages.payment_types') }}
                                </h1>
                                <div class="position-relative payment-container">
                                    <div class="row {{ $newPlan['amountToPay'] <= 0 ? 'd-none' : '' }}">
                                        @if (isset($paymentTypes[1]))
                                            <div class="col-lg-3 p-2">
                                                <div class="mb-xxl-0 mb-4 border-radius" id="stripePayment">
                                                    <div class="selected-box">
                                                        <label class="form-check input-padding">
                                                            <div class="d-flex gap-3 justify-content-between">
                                                                <div class=" mb-3">
                                                                    <svg width="60" height="60" viewBox="0 0 100 100"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <g clip-path="url(#clip0_1_2)">
                                                                            <path
                                                                                d="M50 100C77.6142 100 100 77.6142 100 50C100 22.3858 77.6142 0 50 0C22.3858 0 0 22.3858 0 50C0 77.6142 22.3858 100 50 100Z"
                                                                                fill="white" />
                                                                            <path
                                                                                d="M50 85C69.33 85 85 69.33 85 50C85 30.67 69.33 15 50 15C30.67 15 15 30.67 15 50C15 69.33 30.67 85 50 85Z"
                                                                                fill="#6571FF" />
                                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                                d="M77.1581 50.3095C77.1581 46.4465 75.287 43.3984 71.7107 43.3984C68.1193 43.3984 65.9465 46.4465 65.9465 50.2793C65.9465 54.8212 68.5117 57.115 72.1936 57.115C73.9892 57.115 75.3472 56.7076 76.3735 56.1342V53.1162C75.3474 53.6293 74.1704 53.9461 72.6764 53.9461C71.2127 53.9461 69.915 53.433 69.749 51.6525H77.1279C77.1279 51.4565 77.1581 50.6717 77.1581 50.3095ZM69.7038 48.876C69.7038 47.1709 70.745 46.4617 71.6956 46.4617C72.6161 46.4617 73.597 47.1709 73.597 48.876H69.7038ZM60.1218 43.3985C58.6431 43.3985 57.6923 44.0926 57.1642 44.5755L56.968 43.64H53.6483V61.2346L57.4208 60.4348L57.4359 56.1644C57.979 56.5568 58.7788 57.115 60.1067 57.115C62.8077 57.115 65.2674 54.9421 65.2674 50.1586C65.2523 45.7826 62.7626 43.3985 60.1218 43.3985ZM59.2165 53.7953C58.3262 53.7953 57.798 53.4784 57.4359 53.0861L57.4208 47.4879C57.8132 47.0503 58.3564 46.7485 59.2165 46.7485C60.5897 46.7485 61.5403 48.2877 61.5403 50.2644C61.5403 52.2863 60.6047 53.7953 59.2165 53.7953ZM48.4575 42.5082L52.2451 41.6934V38.6302L48.4575 39.43V42.5082ZM48.4575 43.655H52.2451V56.8585H48.4575V43.655ZM44.3984 44.7717L44.1569 43.6551H40.8975V56.8586H44.67V47.9105C45.5603 46.7485 47.0693 46.9599 47.537 47.1259V43.6553C47.0541 43.474 45.2887 43.142 44.3984 44.7717ZM36.8535 40.3806L33.1717 41.1652L33.1567 53.252C33.1567 55.4853 34.8316 57.13 37.0649 57.13C38.3022 57.13 39.2076 56.9036 39.7056 56.6321V53.5689C39.2227 53.7651 36.8386 54.4592 36.8386 52.2259V46.8691H39.7056V43.655H36.8386L36.8535 40.3806ZM26.6529 47.4878C26.6529 46.8993 27.1358 46.6729 27.9355 46.6729C29.0823 46.6729 30.531 47.0199 31.6778 47.6387V44.0927C30.4253 43.5947 29.188 43.3985 27.9355 43.3985C24.8723 43.3985 22.8352 44.998 22.8352 47.6689C22.8352 51.8337 28.5693 51.1698 28.5693 52.9654C28.5693 53.6595 27.9657 53.886 27.1207 53.886C25.8682 53.886 24.2687 53.3728 23.0012 52.6787V56.2701C24.4045 56.8737 25.8229 57.1301 27.1207 57.1301C30.2593 57.1301 32.4171 55.5759 32.4171 52.8749C32.4021 48.3781 26.6529 49.1779 26.6529 47.4878Z"
                                                                                fill="white" />
                                                                        </g>
                                                                        <defs>
                                                                            <clipPath id="clip0_1_2">
                                                                                <rect width="100" height="100"
                                                                                    fill="white" />
                                                                            </clipPath>
                                                                        </defs>
                                                                    </svg>
                                                                </div>
                                                                <div>
                                                                    <input
                                                                        class="form-check-input capture @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') input-margin @endif"
                                                                        type="radio" name="payment_mode"
                                                                        id="stripePayment" value="stripe_payment">

                                                                </div>
                                                            </div>
                                                            <h6 class="mb-0">{{ __('messages.stripe') }}
                                                            </h6>
                                                            <p class="fs-14p mb-0">{{ __('messages.pay_with_stripe') }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (isset($paymentTypes[2]))
                                            <div class="col-lg-3 p-2">
                                                <div class="mb-xxl-0 mb-4 border-radius" id="paypalPayment">
                                                    <div class="selected-box ">
                                                        <label class="form-check input-padding">
                                                            <div class="d-flex gap-3 justify-content-between">
                                                                <div class=" mb-3">
                                                                    <svg width="60" height="60"
                                                                        viewBox="0 0 100 100" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <g clip-path="url(#clip0_0_3)">
                                                                            <path
                                                                                d="M50 100C77.6142 100 100 77.6142 100 50C100 22.3858 77.6142 0 50 0C22.3858 0 0 22.3858 0 50C0 77.6142 22.3858 100 50 100Z"
                                                                                fill="white" />
                                                                            <path
                                                                                d="M26.5586 73.2487H34.578C35.1708 73.2487 35.7636 73.0869 36.2208 72.7631C36.947 72.3322 37.4589 71.6059 37.6208 70.7441L40.3945 56.5034C40.5778 55.5536 41.0866 54.6975 41.8333 54.0826C42.58 53.4677 43.5178 53.1324 44.4851 53.1347H53.5326C58.0087 53.1324 62.3007 51.3534 65.4659 48.1886C68.6312 45.0238 70.4107 40.7319 70.4136 36.2559V36.0656C70.368 31.654 68.5882 27.4375 65.4589 24.3275C63.8982 22.7536 62.0405 21.5054 59.9936 20.6553C57.9467 19.8051 55.7513 19.3699 53.5348 19.375H34.3395C33.6153 19.376 32.9148 19.6337 32.3625 20.1023C31.8103 20.5708 31.4419 21.22 31.323 21.9344L23.2992 69.425C23.2228 69.8968 23.2498 70.3796 23.3785 70.8399C23.5072 71.3002 23.7345 71.727 24.0445 72.0907C24.3546 72.4544 24.74 72.7464 25.1741 72.9464C25.6082 73.1463 26.0806 73.2495 26.5586 73.2487Z"
                                                                                fill="#6571FF" />
                                                                            <path
                                                                                d="M53.5348 55.8297H44.4895C44.1486 55.832 43.8187 55.9505 43.5542 56.1657C43.2897 56.3809 43.1065 56.6798 43.0348 57.0131L40.2611 71.2537C39.8302 73.5987 37.973 75.375 35.7111 75.8322L35.4705 77.2869C35.173 79.0369 36.5205 80.625 38.2967 80.625H45.3492C46.642 80.625 47.773 79.7106 48.0158 78.4156L50.4395 65.9512C50.7895 64.2297 52.2967 62.9894 54.0467 62.9894H61.9611C65.8803 62.9876 69.6386 61.4301 72.4101 58.659C75.1816 55.8879 76.7397 52.1299 76.742 48.2106C76.742 44.4131 75.342 40.9678 72.973 38.3559C71.9492 48.1822 63.6323 55.8297 53.5348 55.8297Z"
                                                                                fill="#6571FF" />
                                                                        </g>
                                                                        <defs>
                                                                            <clipPath id="clip0_0_3">
                                                                                <rect width="100" height="100"
                                                                                    fill="white" />
                                                                            </clipPath>
                                                                        </defs>
                                                                    </svg>
                                                                </div>
                                                                <div>
                                                                    <input
                                                                        class="form-check-input capture @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') input-margin @endif"
                                                                        type="radio" name="payment_mode"
                                                                        id="paypalPayment" value="paypal_payment">
                                                                </div>
                                                            </div>
                                                            <h6 class="mb-0">{{ __('messages.paypal') }}
                                                            </h6>
                                                            <p class="fs-14p mb-0">{{ __('messages.pay_with_paypal') }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (isset($paymentTypes[3]))
                                            <div class="col-lg-3 p-2">
                                                <div class="mb-xxl-0 mb-4 border-radius" id="razorpayPayment">
                                                    <div class="selected-box ">
                                                        <label class="form-check input-padding">
                                                            <div class="d-flex gap-3 justify-content-between">
                                                                <div class=" mb-3">
                                                                    <svg width="60" height="60"
                                                                        viewBox="0 0 100 100" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <g clip-path="url(#clip0_31_5)">
                                                                            <path
                                                                                d="M50 100C77.6142 100 100 77.6142 100 50C100 22.3858 77.6142 0 50 0C22.3858 0 0 22.3858 0 50C0 77.6142 22.3858 100 50 100Z"
                                                                                fill="white" />
                                                                            <path
                                                                                d="M17.8335 65.6662C17.6814 66.218 17.3885 66.6232 16.9516 66.882C16.5157 67.1403 15.904 67.27 15.1143 67.27H12.6055L13.4864 64.0635H15.9952C16.7838 64.0635 17.3256 64.1921 17.6196 64.4544C17.9135 64.7166 17.9845 65.1175 17.8335 65.6717M20.4309 65.6024C20.7502 64.4445 20.6185 63.5538 20.0346 62.9303C19.4518 62.3117 18.429 62 16.9693 62H11.3704L8 74.2769H10.7201L12.0784 69.3285H13.8625C14.2629 69.3285 14.5781 69.3928 14.8082 69.5165C15.0388 69.6452 15.1741 69.8679 15.2157 70.1895L15.7012 74.2769H18.6155L18.1431 70.4666C18.0468 69.6155 17.648 69.1157 16.947 68.9673C17.8406 68.7149 18.5891 68.2943 19.1923 67.7104C19.7912 67.1308 20.2191 66.4043 20.4309 65.6073M27.043 69.8827C26.8149 70.714 26.4652 71.3425 25.9924 71.7829C25.519 72.2233 24.9534 72.441 24.2935 72.441C23.6214 72.441 23.1658 72.2282 22.925 71.7977C22.6838 71.3672 22.6757 70.7437 22.8997 69.9273C23.1237 69.1108 23.481 68.4724 23.9726 68.0122C24.4643 67.5521 25.039 67.322 25.6989 67.322C26.3578 67.322 26.8089 67.5446 27.0369 67.9865C27.2701 68.4304 27.2751 69.0653 27.0471 69.8916L27.043 69.8827ZM28.2351 65.5381L27.8945 66.7801C27.7475 66.3348 27.4622 65.9785 27.0405 65.7113C26.6178 65.449 26.0947 65.3154 25.4708 65.3154C24.7055 65.3154 23.9706 65.5084 23.2661 65.8944C22.5616 66.2803 21.9433 66.8246 21.4162 67.5273C20.8891 68.23 20.5039 69.0267 20.2556 69.9223C20.0123 70.8229 19.9616 71.6097 20.1086 72.2926C20.2607 72.9804 20.58 73.5049 21.0716 73.8711C21.5683 74.2422 22.2018 74.4253 22.9772 74.4253C23.5934 74.4284 24.2027 74.2982 24.7613 74.0443C25.3136 73.8011 25.8048 73.4431 26.2007 72.9952L25.8459 74.2897H28.4763L30.8782 65.5425H28.2427L28.2351 65.5381ZM40.3305 65.5381H32.6809L32.1462 67.4877H36.5972L30.7129 72.4509L30.2102 74.2818H38.1065L38.6412 72.3322H33.872L39.8465 67.2947M47.0637 69.8679C46.827 70.7289 46.4758 71.3761 46.012 71.7977C45.5483 72.2233 44.9867 72.4361 44.3273 72.4361C42.9488 72.4361 42.4957 71.58 42.966 69.8679C43.1991 69.0168 43.5519 68.3769 44.0232 67.9459C44.4946 67.5135 45.0658 67.2977 45.7373 67.2977C46.3962 67.2977 46.8412 67.512 47.0703 67.9435C47.2994 68.374 47.2973 69.0158 47.0637 69.8669M48.6034 65.8671C47.9978 65.499 47.2248 65.3149 46.2822 65.3149C45.3278 65.3149 44.4444 65.498 43.6314 65.8642C42.8219 66.2281 42.1104 66.7713 41.5535 67.4506C40.9807 68.1384 40.5687 68.945 40.3158 69.8654C40.0674 70.7823 40.037 71.5874 40.2296 72.2767C40.4222 72.9646 40.8277 73.494 41.4359 73.8602C42.0491 74.2294 42.8297 74.4129 43.7876 74.4129C44.7303 74.4129 45.6071 74.2279 46.4129 73.8597C47.2188 73.4896 47.9081 72.9641 48.4808 72.2713C49.0535 71.5815 49.464 70.7769 49.7174 69.8565C49.9708 68.9361 50.0013 68.1325 49.8087 67.4417C49.6161 66.7539 49.2157 66.2244 48.6125 65.8558M57.9939 67.8747L58.668 65.4945C58.4399 65.3807 58.1409 65.3213 57.7658 65.3213C57.1627 65.3213 56.5849 65.4668 56.0274 65.7617C55.548 66.0121 55.1405 66.3654 54.7958 66.8078L55.1455 65.5262L54.3818 65.5292H52.5065L50.0889 74.2729H52.7564L54.0107 69.7021C54.1932 69.0375 54.5216 68.5145 54.9955 68.1434C55.4669 67.7708 56.0548 67.5842 56.7643 67.5842C57.2002 67.5842 57.6057 67.6817 57.9909 67.8762M65.4159 69.9099C65.1878 70.7264 64.8432 71.3499 64.3718 71.7804C63.9005 72.2129 63.3328 72.4287 62.6739 72.4287C62.0151 72.4287 61.564 72.2109 61.3258 71.7755C61.0825 71.3375 61.0774 70.7066 61.3055 69.8773C61.5336 69.0484 61.8833 68.4126 62.3648 67.9722C62.8463 67.5283 63.4139 67.3066 64.0728 67.3066C64.7215 67.3066 65.1574 67.5342 65.3905 67.9944C65.6237 68.4546 65.6287 69.093 65.4047 69.9094M67.2699 65.8815C66.7757 65.4955 66.1447 65.3025 65.3794 65.3025C64.7089 65.3025 64.0697 65.451 63.4636 65.7509C62.8579 66.0502 62.3663 66.4585 61.9887 66.9751L61.9978 66.9157L62.4454 65.5252H59.8403L59.1763 67.9449L59.1561 68.0291L56.4192 77.997H59.0902L60.4687 72.9794C60.6056 73.4257 60.8843 73.7761 61.3101 74.0294C61.7358 74.2818 62.2614 74.407 62.8863 74.407C63.6618 74.407 64.4017 74.2239 65.1037 73.8577C65.8082 73.4906 66.4164 72.9621 66.9333 72.2792C67.4503 71.5963 67.834 70.8046 68.0787 69.909C68.3271 69.0118 68.3778 68.2117 68.2359 67.5115C68.0914 66.8103 67.7716 66.2675 67.278 65.8835M76.1297 69.8743C75.9016 70.7007 75.5519 71.3341 75.0806 71.7695C74.6092 72.208 74.0416 72.4262 73.3827 72.4262C72.7086 72.4262 72.2525 72.2134 72.0143 71.7829C71.771 71.3524 71.7659 70.7289 71.9889 69.9124C72.2119 69.0959 72.5677 68.4576 73.0593 67.9974C73.551 67.5372 74.1262 67.3076 74.7861 67.3076C75.445 67.3076 75.891 67.5303 76.1241 67.9707C76.3573 68.4126 76.3588 69.0474 76.1317 69.8758L76.1297 69.8743ZM77.3207 65.5272L76.9796 66.7692C76.8327 66.3214 76.5488 65.9651 76.1282 65.7004C75.7024 65.4361 75.1804 65.3045 74.557 65.3045C73.7917 65.3045 73.0527 65.4975 72.3472 65.8835C71.6428 66.2694 71.0244 66.8108 70.4973 67.5115C69.9702 68.2122 69.585 69.0108 69.3367 69.9065C69.0909 70.8056 69.0427 71.5939 69.1897 72.2797C69.3382 72.9626 69.658 73.4901 70.1527 73.8582C70.6463 74.2244 71.2829 74.4095 72.0584 74.4095C72.6818 74.4095 73.2773 74.2828 73.8424 74.0285C74.3934 73.7841 74.8833 73.4256 75.2782 72.9779L74.9234 74.2734H77.5539L79.9552 65.5297H77.3248L77.3207 65.5272ZM90.9985 65.5302L91 65.5277H89.3832C89.3315 65.5277 89.2859 65.5302 89.2388 65.5311H88.4L87.9692 66.115L87.8627 66.2536L87.8171 66.3229L84.4087 70.9585L83.7042 65.5302H80.9126L82.3267 73.7791L79.2046 78H81.9871L82.7423 76.9544C82.7635 76.9237 82.7828 76.898 82.8082 76.8653L83.69 75.6431L83.7154 75.6085L87.6651 70.1405L90.9949 65.5386L91 65.5356H90.9985V65.5302Z"
                                                                                fill="#6571FF" />
                                                                            <path
                                                                                d="M42.3868 28.1917L40 37.1123L53.6614 28.1409L44.7266 61.9923L53.8008 62L67 12"
                                                                                fill="#6571FF" />
                                                                            <path
                                                                                d="M28.4391 49.22L25 62H42.0272L51 32L28.4391 49.22Z"
                                                                                fill="#6571FF" />
                                                                        </g>
                                                                        <defs>
                                                                            <clipPath id="clip0_31_5">
                                                                                <rect width="100" height="100"
                                                                                    fill="white" />
                                                                            </clipPath>
                                                                        </defs>
                                                                    </svg>
                                                                </div>
                                                                <div>
                                                                    <input
                                                                        class="form-check-input capture @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') input-margin @endif"
                                                                        type="radio" name="payment_mode"
                                                                        id="razorpayPayment" value="razorpay_payment">
                                                                </div>
                                                            </div>
                                                            <h6 class="mb-0">{{ __('messages.razorpay') }}
                                                            </h6>
                                                            <p class="fs-14p mb-0">{{ __('messages.pay_with_razorpay') }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (isset($paymentTypes[5]))
                                            <div class="col-lg-3 p-2">
                                                <div class="mb-xxl-0 mb-4 border-radius" id="paystackPayment">
                                                    <div class="selected-box ">
                                                        <label class="form-check input-padding">
                                                            <div class="d-flex gap-3 justify-content-between">
                                                                <div class=" mb-3">
                                                                    <svg class="paystack-custom-icon mt-2 mb-2"
                                                                        width="90" height="17" viewBox="0 0 90 17"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M12.8097 1.515H0.749985C0.344993 1.515 0 1.85999 0 2.27998V3.64495C0 4.06494 0.344993 4.40994 0.749985 4.40994H12.8097C13.2297 4.40994 13.5597 4.06494 13.5747 3.64495V2.29498C13.5747 1.85999 13.2297 1.515 12.8097 1.515ZM12.8097 9.08984H0.749985C0.554989 9.08984 0.359993 9.16484 0.224995 9.31484C0.0749984 9.46483 0 9.64483 0 9.85482V11.2198C0 11.6398 0.344993 11.9848 0.749985 11.9848H12.8097C13.2297 11.9848 13.5597 11.6548 13.5747 11.2198V9.85482C13.5597 9.41983 13.2297 9.08984 12.8097 9.08984ZM7.54484 12.8698H0.749985C0.554989 12.8698 0.359993 12.9448 0.224995 13.0948C0.0899981 13.2448 0 13.4248 0 13.6347V14.9997C0 15.4197 0.344993 15.7647 0.749985 15.7647H7.52984C7.94984 15.7647 8.27983 15.4197 8.27983 15.0147V13.6497C8.29483 13.1998 7.96484 12.8698 7.54484 12.8698ZM13.5747 5.29492H0.749985C0.554989 5.29492 0.359993 5.36992 0.224995 5.51991C0.0899981 5.66991 0 5.84991 0 6.0599V7.42488C0 7.84487 0.344993 8.18986 0.749985 8.18986H13.5597C13.9797 8.18986 14.3097 7.84487 14.3097 7.42488V6.0599C14.3247 5.65491 13.9797 5.30992 13.5747 5.29492Z"
                                                                            fill="#6571FF" />
                                                                        <path
                                                                            d="M27.5994 4.57491C27.2244 4.18491 26.7894 3.88492 26.2944 3.67492C25.7994 3.46493 25.2745 3.35993 24.7345 3.35993C24.2095 3.34493 23.6995 3.46493 23.2195 3.68992C22.9045 3.83992 22.6195 4.04991 22.3795 4.30491V4.06492C22.3795 3.94492 22.3345 3.82492 22.2595 3.73492C22.1845 3.64492 22.0645 3.58492 21.9295 3.58492H20.2646C20.1446 3.58492 20.0246 3.62992 19.9496 3.73492C19.8596 3.82492 19.8146 3.94492 19.8296 4.06492V15.2847C19.8296 15.4047 19.8746 15.5247 19.9496 15.6147C20.0396 15.7047 20.1446 15.7497 20.2646 15.7497H21.9745C22.0945 15.7497 22.1995 15.7047 22.2895 15.6147C22.3795 15.5397 22.4395 15.4197 22.4245 15.2847V11.4448C22.6645 11.7148 22.9795 11.9097 23.3245 12.0297C23.7745 12.1947 24.2395 12.2847 24.7195 12.2847C25.2595 12.2847 25.7994 12.1797 26.2944 11.9698C26.7894 11.7598 27.2394 11.4598 27.6144 11.0698C28.0044 10.6648 28.3044 10.1848 28.5144 9.6598C28.7544 9.07481 28.8594 8.44483 28.8444 7.81484C28.8594 7.18485 28.7394 6.55486 28.5144 5.95487C28.2894 5.45988 27.9894 4.9799 27.5994 4.57491ZM26.0694 8.63982C25.9794 8.87982 25.8444 9.08981 25.6644 9.28481C25.3194 9.6598 24.8245 9.86979 24.3145 9.86979C24.0595 9.86979 23.8045 9.82479 23.5645 9.7048C23.3395 9.5998 23.1295 9.4648 22.9495 9.28481C22.7695 9.10481 22.6345 8.87982 22.5445 8.63982C22.3495 8.12983 22.3495 7.57484 22.5445 7.06485C22.6345 6.82486 22.7845 6.61486 22.9495 6.43487C23.1295 6.25487 23.3395 6.10487 23.5645 5.99988C23.8045 5.89488 24.0595 5.83488 24.3145 5.83488C24.5845 5.83488 24.8245 5.87988 25.0795 5.99988C25.3045 6.10487 25.5144 6.23987 25.6794 6.41987C25.8594 6.59986 25.9794 6.80986 26.0844 7.04985C26.2644 7.57484 26.2494 8.12983 26.0694 8.63982ZM38.0092 3.59993H36.3142C36.1942 3.59993 36.0742 3.64492 35.9992 3.73492C35.9092 3.82492 35.8642 3.94492 35.8642 4.07991V4.28991C35.6542 4.03492 35.3842 3.83992 35.0992 3.70492C34.6343 3.47993 34.1243 3.37493 33.6143 3.37493C32.5193 3.37493 31.4843 3.80992 30.7043 4.57491C30.2993 4.9799 29.9844 5.45989 29.7744 5.98488C29.5344 6.56986 29.4144 7.19985 29.4294 7.84484C29.4144 8.47482 29.5344 9.10481 29.7744 9.7048C29.9994 10.2298 30.2993 10.7098 30.7043 11.1148C31.4693 11.8948 32.5193 12.3297 33.5993 12.3297C34.1093 12.3447 34.6193 12.2247 35.0842 11.9998C35.3692 11.8498 35.6542 11.6548 35.8642 11.4148V11.6398C35.8642 11.7598 35.9092 11.8798 35.9992 11.9698C36.0892 12.0447 36.1942 12.1047 36.3142 12.1047H38.0092C38.1292 12.1047 38.2492 12.0597 38.3242 11.9698C38.4142 11.8798 38.4592 11.7598 38.4592 11.6398V4.09491C38.4592 3.97492 38.4142 3.85492 38.3392 3.76492C38.2492 3.65992 38.1292 3.59993 38.0092 3.59993ZM35.7142 8.63982C35.6242 8.87982 35.4892 9.08981 35.3092 9.28481C35.1292 9.4648 34.9343 9.6148 34.7093 9.7198C34.2293 9.94479 33.6743 9.94479 33.1943 9.7198C32.9693 9.6148 32.7593 9.4648 32.5793 9.28481C32.3993 9.10481 32.2643 8.87982 32.1743 8.63982C31.9943 8.12983 31.9943 7.57484 32.1743 7.06485C32.2643 6.82486 32.3993 6.62986 32.5793 6.43487C32.7593 6.25487 32.9543 6.10487 33.1943 5.99988C33.6743 5.77488 34.2293 5.77488 34.6943 5.99988C34.9193 6.10487 35.1292 6.23987 35.2942 6.41987C35.4592 6.59986 35.5942 6.80986 35.6992 7.04985C35.9092 7.57484 35.9092 8.12983 35.7142 8.63982ZM54.8988 7.61984C54.6588 7.40984 54.3738 7.22985 54.0739 7.10985C53.7589 6.97485 53.4139 6.88486 53.0839 6.80986L51.7939 6.55486C51.4639 6.49486 51.2239 6.40487 51.1039 6.29987C50.9989 6.22487 50.9239 6.10487 50.9239 5.96987C50.9239 5.83488 50.9989 5.71488 51.1639 5.60988C51.3889 5.48989 51.6289 5.42989 51.8839 5.44489C52.2139 5.44489 52.5439 5.51989 52.8439 5.63988C53.1439 5.77488 53.4289 5.90988 53.6989 6.08987C54.0739 6.32987 54.4039 6.28487 54.6288 6.01488L55.2438 5.30989C55.3638 5.18989 55.4238 5.0399 55.4388 4.8749C55.4238 4.6949 55.3338 4.54491 55.1988 4.42491C54.9438 4.19991 54.5238 3.95992 53.9689 3.71992C53.4139 3.47993 52.7089 3.35993 51.8839 3.35993C51.3739 3.34493 50.8789 3.41993 50.3989 3.56992C49.9939 3.70492 49.6039 3.89992 49.259 4.15491C48.944 4.39491 48.704 4.6949 48.524 5.05489C48.359 5.39989 48.269 5.77488 48.269 6.14987C48.269 6.85486 48.479 7.42484 48.899 7.84484C49.319 8.26483 49.8739 8.54982 50.5639 8.68482L51.9139 8.98481C52.1989 9.02981 52.4989 9.11981 52.7689 9.25481C52.9189 9.3148 53.0089 9.4648 53.0089 9.6298C53.0089 9.77979 52.9339 9.91479 52.7689 10.0348C52.6039 10.1548 52.3339 10.2298 51.9739 10.2298C51.6139 10.2298 51.2389 10.1548 50.9089 9.98979C50.5939 9.8398 50.3089 9.6448 50.0389 9.4198C49.9189 9.3298 49.7989 9.25481 49.6489 9.19481C49.499 9.14981 49.304 9.19481 49.109 9.35981L48.374 9.9148C48.164 10.0648 48.059 10.3198 48.119 10.5598C48.164 10.8148 48.359 11.0548 48.734 11.3398C49.6639 11.9698 50.7739 12.2997 51.8989 12.2697C52.4239 12.2697 52.9489 12.2097 53.4439 12.0597C53.8789 11.9248 54.2839 11.7298 54.6438 11.4598C54.9738 11.2198 55.2438 10.9048 55.4238 10.5298C55.6038 10.1698 55.6938 9.7798 55.6938 9.37481C55.7088 9.01481 55.6338 8.65482 55.4838 8.32483C55.3338 8.08483 55.1388 7.82984 54.8988 7.61984ZM62.3087 9.6748C62.2337 9.5398 62.0987 9.4498 61.9337 9.4198C61.7837 9.4198 61.6187 9.4648 61.4987 9.5548C61.2887 9.6898 61.0487 9.7648 60.8087 9.77979C60.7337 9.77979 60.6437 9.7648 60.5687 9.7498C60.4787 9.7348 60.4037 9.6898 60.3437 9.6298C60.2687 9.5548 60.2087 9.4648 60.1637 9.37481C60.1037 9.22481 60.0737 9.07481 60.0887 8.92482V5.84988H62.2787C62.4137 5.84988 62.5337 5.78988 62.6237 5.69988C62.7137 5.60988 62.7737 5.50488 62.7737 5.36989V4.06492C62.7737 3.92992 62.7287 3.80992 62.6237 3.73492C62.5337 3.64492 62.4137 3.59993 62.2937 3.59993H60.0887V1.49997C60.0887 1.37997 60.0437 1.24497 59.9537 1.16997C59.8637 1.09498 59.7587 1.04998 59.6387 1.03498H57.9288C57.8088 1.03498 57.6888 1.07998 57.5988 1.16997C57.5088 1.25997 57.4488 1.37997 57.4488 1.49997V3.59993H56.4738C56.3538 3.59993 56.2338 3.64492 56.1438 3.74992C56.0688 3.83992 56.0238 3.95992 56.0238 4.07991V5.38489C56.0238 5.50489 56.0688 5.62488 56.1438 5.71488C56.2188 5.81988 56.3388 5.86488 56.4738 5.86488H57.4488V9.5248C57.4338 9.95979 57.5238 10.3948 57.7038 10.7848C57.8688 11.1148 58.0788 11.3998 58.3638 11.6398C58.6338 11.8648 58.9488 12.0297 59.2938 12.1197C59.6387 12.2247 59.9987 12.2847 60.3587 12.2847C60.8237 12.2847 61.3037 12.2097 61.7537 12.0597C62.1737 11.9248 62.5487 11.6848 62.8487 11.3698C63.0437 11.1748 63.0587 10.8598 62.9087 10.6348L62.3087 9.6748ZM71.5785 3.59993H69.8835C69.7635 3.59993 69.6585 3.64492 69.5685 3.73492C69.4785 3.82492 69.4335 3.94492 69.4335 4.07991V4.28991C69.2235 4.03492 68.9686 3.83992 68.6686 3.70492C68.2036 3.47993 67.6936 3.37493 67.1836 3.37493C66.0886 3.37493 65.0536 3.80992 64.2736 4.57491C63.8687 4.9799 63.5537 5.45989 63.3437 5.98488C63.1037 6.56986 62.9837 7.19985 62.9987 7.82983C62.9837 8.45982 63.1037 9.08981 63.3437 9.6898C63.5537 10.2148 63.8837 10.6948 64.2736 11.0998C65.0386 11.8798 66.0736 12.3147 67.1686 12.3147C67.6786 12.3297 68.1886 12.2097 68.6536 11.9998C68.9536 11.8498 69.2235 11.6548 69.4335 11.4148V11.6398C69.4335 11.7598 69.4785 11.8798 69.5685 11.9547C69.6585 12.0447 69.7635 12.0898 69.8835 12.0898H71.5785C71.8335 12.0898 72.0285 11.8948 72.0285 11.6398V4.09491C72.0285 3.97492 71.9835 3.85492 71.9085 3.76492C71.8335 3.65992 71.7135 3.59993 71.5785 3.59993ZM69.2985 8.65482C69.2085 8.89481 69.0735 9.10481 68.8936 9.29981C68.7136 9.4798 68.5186 9.6298 68.2936 9.7348C68.0536 9.8398 67.7986 9.89979 67.5286 9.89979C67.2586 9.89979 67.0186 9.8398 66.7786 9.7348C66.5536 9.6298 66.3436 9.4798 66.1636 9.29981C65.9836 9.11981 65.8486 8.89481 65.7736 8.65482C65.5936 8.14483 65.5936 7.58984 65.7736 7.07985C65.8636 6.83986 65.9986 6.62986 66.1636 6.44987C66.3436 6.26987 66.5536 6.11987 66.7786 6.01488C67.0186 5.90988 67.2736 5.84988 67.5286 5.84988C67.7836 5.84988 68.0386 5.89488 68.2936 6.01488C68.5186 6.11987 68.7136 6.25487 68.8936 6.43487C69.0735 6.61486 69.2085 6.82486 69.2985 7.06485C69.4935 7.55984 69.4935 8.14483 69.2985 8.65482ZM80.8783 9.5698L79.9033 8.81982C79.7233 8.66982 79.5433 8.62482 79.3933 8.68482C79.2583 8.74482 79.1383 8.83482 79.0333 8.93982C78.8233 9.19481 78.5684 9.41981 78.2984 9.6148C77.9984 9.7798 77.6834 9.8698 77.3534 9.8398C76.9634 9.8398 76.6034 9.7348 76.2884 9.5098C75.9734 9.28481 75.7334 8.98481 75.6134 8.60982C75.5234 8.35483 75.4784 8.09983 75.4784 7.84484C75.4784 7.57484 75.5234 7.31985 75.6134 7.04985C75.7034 6.80986 75.8234 6.59986 76.0034 6.41987C76.1834 6.23987 76.3784 6.08987 76.6034 5.99988C76.8434 5.89488 77.0984 5.83488 77.3684 5.83488C77.6984 5.81988 78.0284 5.90988 78.3134 6.07487C78.5984 6.25487 78.8383 6.47987 79.0483 6.74986C79.1383 6.85486 79.2583 6.94485 79.3933 7.00485C79.5433 7.06485 79.7233 7.01985 79.9033 6.86986L80.8783 6.13487C80.9983 6.05987 81.0883 5.93987 81.1333 5.80488C81.1933 5.65488 81.1783 5.48988 81.0883 5.35489C80.7133 4.7699 80.2033 4.28991 79.5883 3.94492C78.9433 3.58492 78.1784 3.38993 77.3234 3.38993C76.7234 3.38993 76.1234 3.50993 75.5534 3.73492C75.0134 3.95992 74.5334 4.27491 74.1284 4.6799C73.7235 5.08489 73.3935 5.56488 73.1685 6.10487C72.7035 7.22985 72.7035 8.48983 73.1685 9.6148C73.3935 10.1398 73.7085 10.6348 74.1284 11.0248C74.9834 11.8648 76.1234 12.3147 77.3234 12.3147C78.1784 12.3147 78.9433 12.1197 79.5883 11.7598C80.2033 11.4148 80.7283 10.9348 81.1033 10.3348C81.1783 10.1998 81.1933 10.0348 81.1483 9.89979C81.0883 9.7798 80.9983 9.6598 80.8783 9.5698ZM89.9081 11.3248L87.2232 7.39485L89.5181 4.36491C89.6231 4.22991 89.6681 4.03491 89.6081 3.86992C89.5631 3.74992 89.4581 3.62992 89.1731 3.62992H87.3582C87.2532 3.62992 87.1482 3.65992 87.0582 3.70492C86.9382 3.76492 86.8482 3.85492 86.7882 3.95992L84.9582 6.52486H84.5232V0.464991C84.5232 0.344994 84.4782 0.224994 84.3882 0.134996C84.2982 0.0449981 84.1932 0 84.0732 0H82.3783C82.2583 0 82.1383 0.0449981 82.0483 0.134996C81.9583 0.224994 81.9133 0.329994 81.9133 0.464991V11.6398C81.9133 11.7748 81.9583 11.8798 82.0483 11.9698C82.1383 12.0597 82.2583 12.1047 82.3783 12.1047H84.0732C84.1932 12.1047 84.3132 12.0597 84.3882 11.9698C84.4782 11.8798 84.5232 11.7598 84.5232 11.6398V8.68482H85.0032L86.9982 11.7448C87.1182 11.9698 87.3432 12.1047 87.5832 12.1047H89.4881C89.7731 12.1047 89.8931 11.9698 89.9531 11.8498C90.0281 11.6548 90.0131 11.4598 89.9081 11.3248ZM47.639 3.61493H45.734C45.584 3.61493 45.449 3.65992 45.344 3.76492C45.254 3.85492 45.194 3.95992 45.164 4.07991L43.7541 9.29981H43.4091L41.9091 4.07991C41.8791 3.97491 41.8341 3.86992 41.7591 3.76492C41.6691 3.65992 41.5491 3.59993 41.4141 3.59993H39.4792C39.2242 3.59993 39.0742 3.67492 38.9992 3.85492C38.9542 4.00491 38.9542 4.16991 38.9992 4.31991L41.3991 11.6698C41.4441 11.7748 41.4891 11.8948 41.5791 11.9698C41.6691 12.0597 41.8041 12.1047 41.9391 12.1047H42.9591L42.8691 12.3447L42.6441 13.0197C42.5691 13.2297 42.4491 13.4097 42.2691 13.5447C42.1041 13.6647 41.9091 13.7397 41.6991 13.7247C41.5191 13.7247 41.3541 13.6797 41.1891 13.6197C41.0241 13.5447 40.8741 13.4547 40.7391 13.3497C40.6191 13.2597 40.4691 13.2147 40.3041 13.2147H40.2891C40.1091 13.2297 39.9441 13.3197 39.8542 13.4847L39.2542 14.3697C39.0142 14.7597 39.1492 14.9997 39.2992 15.1347C39.6292 15.4347 40.0041 15.6597 40.4241 15.7947C40.8891 15.9597 41.3691 16.0347 41.8491 16.0347C42.7191 16.0347 43.4391 15.7947 43.9941 15.3297C44.5641 14.8197 44.999 14.1597 45.209 13.4097L47.999 4.31991C48.059 4.15491 48.074 3.98992 48.014 3.83992C47.999 3.73492 47.894 3.59993 47.639 3.61493Z"
                                                                            fill="#6571FF" />
                                                                    </svg>

                                                                </div>
                                                                <div>
                                                                    <input
                                                                        class="form-check-input capture @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') input-margin @endif "
                                                                        type="radio" name="payment_mode"
                                                                        id="paystackPayment" value="paystack_payment">
                                                                </div>
                                                            </div>
                                                            <h6 class="mb-0">{{ __('messages.paystack') }}
                                                            </h6>
                                                            <p class="fs-14p mb-0">{{ __('messages.pay_with_paystack') }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (isset($paymentTypes[6]))
                                            <div class="col-lg-3 p-2">
                                                <div class="mb-xxl-0 mb-4 border-radius" id="phonePePayment">
                                                    <div class="selected-box ">
                                                        <label class="form-check input-padding">
                                                            <div class="d-flex gap-3 justify-content-between">
                                                                <div class=" mb-3">
                                                                    <svg width="60" height="60"
                                                                        viewBox="0 0 100 100" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <g clip-path="url(#clip0_1_31)">
                                                                            <path
                                                                                d="M50 100C77.6142 100 100 77.6142 100 50C100 22.3858 77.6142 0 50 0C22.3858 0 0 22.3858 0 50C0 77.6142 22.3858 100 50 100Z"
                                                                                fill="white" />
                                                                            <path
                                                                                d="M50 85C69.33 85 85 69.33 85 50C85 30.67 69.33 15 50 15C30.67 15 15 30.67 15 50C15 69.33 30.67 85 50 85Z"
                                                                                fill="#6571FF" />
                                                                            <path
                                                                                d="M65.8853 40.866C65.8853 39.4978 64.7119 38.3244 63.3437 38.3244H58.6514L47.8976 26.0065C46.9201 24.8331 45.356 24.4424 43.7919 24.8331L40.0771 26.0065C39.4904 26.2024 39.2945 26.9839 39.6863 27.3747L51.4176 38.5203H33.6227C33.036 38.5203 32.6453 38.9111 32.6453 39.4978V41.4526C32.6453 42.8208 33.8186 43.9942 35.1868 43.9942H37.9242V53.3798C37.9242 60.4188 41.6391 64.5254 47.8965 64.5254C49.8514 64.5254 51.4165 64.3295 53.3714 63.548V69.8054C53.3714 71.5654 54.7396 72.9336 56.4996 72.9336H59.2371C59.8237 72.9336 60.4104 72.347 60.4104 71.7603V43.7993H64.9078C65.4945 43.7993 65.8853 43.4085 65.8853 42.8219V40.866ZM53.3714 57.6813C52.1981 58.268 50.634 58.4639 49.4606 58.4639C46.3324 58.4639 44.7683 56.8998 44.7683 53.3798V43.9942H53.3714V57.6813Z"
                                                                                fill="white" />
                                                                        </g>
                                                                        <defs>
                                                                            <clipPath id="clip0_1_31">
                                                                                <rect width="100" height="100"
                                                                                    fill="white" />
                                                                            </clipPath>
                                                                        </defs>
                                                                    </svg>
                                                                </div>
                                                                <div>
                                                                    <input
                                                                        class="form-check-input capture @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') input-margin @endif"
                                                                        type="radio" name="payment_mode"
                                                                        id="phonePePayment" value="phone_pe_payment">
                                                                </div>
                                                            </div>
                                                            <h6 class="mb-0">{{ __('messages.phonepe') }}
                                                            </h6>
                                                            <p class="fs-14p mb-0">{{ __('messages.pay_with_phonepe') }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (isset($paymentTypes[7]))
                                            <div class="col-lg-3 p-2">
                                                <div class="mb-xxl-0 mb-4 border-radius" id="flutterwavePayment">
                                                    <div class="selected-box ">
                                                        <label class="form-check input-padding">
                                                            <div class="d-flex gap-3 justify-content-between">
                                                                <div class=" mb-3">
                                                                    <svg class="custom-icon mt-2 mb-2" width="17"
                                                                        height="17" viewBox="0 0 17 17" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M12.1407 0.133175C19.6913 -1.00085 14.8537 5.43009 12.5139 7.23879C14.1216 8.4733 15.7724 10.2102 16.4758 12.1768C17.7821 15.7799 14.5666 16.311 12.1407 15.4067C9.48502 14.4736 7.14519 12.4783 5.59487 10.1385C5.16423 10.1385 4.69052 10.0667 4.24552 9.93748C5.12117 12.4065 5.49439 14.9329 5.25036 17C5.25036 12.8372 3.2694 8.70297 0.412801 5.25783C-0.592034 4.05203 0.441509 3.16203 1.34586 4.32477C1.96312 5.1717 2.52295 6.04734 3.02537 6.95169C4.01585 3.56397 8.83905 0.606882 12.1407 0.133175ZM11.064 6.26266C12.5426 5.35831 17.0356 0.535109 12.844 0.965752C10.4324 1.23849 7.50406 3.46348 6.29826 4.89896C7.97777 4.69799 9.68598 5.43009 11.064 6.26266ZM6.90116 10.0093C8.25051 11.5165 10.0879 12.9807 12.0689 13.5118C13.2173 13.8133 14.4805 13.6841 14.0211 12.0476C13.5474 10.5404 12.3416 9.21975 11.1645 8.21491C10.8344 8.44459 10.4611 8.68862 10.0879 8.84652C9.08308 9.40636 8.00648 9.80829 6.90116 10.0093Z"
                                                                            fill="#6571FF" />
                                                                        <path
                                                                            d="M6.25536 5.96117C7.40374 5.86069 8.63825 6.46359 9.58567 7.06649C8.68132 7.49713 7.67648 7.76987 6.62858 7.82729C5.09262 7.84165 4.77682 6.10472 6.25536 5.96117Z"
                                                                            fill="white" />
                                                                    </svg>
                                                                </div>
                                                                <div>
                                                                    <input
                                                                        class="form-check-input capture @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') input-margin @endif"
                                                                        type="radio" name="payment_mode"
                                                                        id="flutterwavePayment"
                                                                        value="flutterwave_payment">
                                                                </div>
                                                            </div>
                                                            <h6 class="mb-0">{{ __('messages.flutterwave') }}
                                                            </h6>
                                                            <p class="fs-14p mb-0">
                                                                {{ __('messages.pay_with_flutterwave') }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        {{-- payfast section start --}}
                                        @if (isset($paymentTypes[9]))
                                            <div class="col-lg-3 p-2">
                                                <div class="mb-xxl-0 mb-4 border-radius" id="payfastPayment">
                                                    <div class="selected-box ">
                                                        <label class="form-check input-padding">
                                                            <div class="d-flex gap-3 justify-content-between">
                                                                <div class=" mb-3">
                                                                    <img src="{{ asset('images/payfast-logo.svg') }}"
                                                                        class="mt-2 mb-2" height="45" width="90" alt="image">
                                                                </div>
                                                                <div>
                                                                    <input
                                                                        class="form-check-input capture @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') input-margin @endif"
                                                                        type="radio" name="payment_mode"
                                                                        id="payfastPayment" value="payfast_payment">
                                                                </div>
                                                            </div>
                                                            <h6 class="mb-0">{{ __('messages.setting.payfast') }}
                                                            </h6>
                                                            <p class="fs-14p mb-0">
                                                                {{ __('messages.pay_with_payfast') }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        {{-- payfast section end --}}

                                        {{-- iyzicoPayment section start --}}
                                        @if (isset($paymentTypes[11]))
                                            <div class="col-lg-3 p-2">
                                                <div class="mb-xxl-0 mb-4 border-radius" id="iyzicoPayment">
                                                    <div class="selected-box ">
                                                        <label class="form-check input-padding">
                                                            <div class="d-flex gap-3 justify-content-between">
                                                                <div class=" mb-3">
                                                                    <img src="{{ asset('images/iyzico.png') }}"
                                                                        class="custom-icon mt-2 mb-2" alt="image">
                                                                </div>
                                                                <div>
                                                                    <input
                                                                        class="form-check-input capture @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') input-margin @endif"
                                                                        type="radio" name="payment_mode"
                                                                        id="iyzicoPayment" value="iyzico_payment">
                                                                </div>
                                                            </div>
                                                            <h6 class="mb-0">{{ __('Iyzico') }}
                                                            </h6>
                                                            <p class="fs-14p mb-0">
                                                                {{ __('Pay with Iyzico') }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        {{-- iyzicoPayment section end --}}


                                        @if (moduleExists('MercadoPago') && isset($paymentTypes[8]))
                                            <div class="col-lg-3 p-2">
                                                <div class="mb-xxl-0 mb-4 border-radius" id="mercadoPagoPayment">
                                                    <div class="selected-box ">
                                                        <label class="form-check input-padding">
                                                            <div class="d-flex gap-3 justify-content-between">
                                                                <div class=" mb-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="custom-icon mt-2 mb-2"
                                                                        viewBox="0 0 640 512">
                                                                        <path
                                                                            d="M272.2 64.6l-51.1 51.1c-15.3 4.2-29.5 11.9-41.5 22.5L153 161.9C142.8 171 129.5 176 115.8 176L96 176l0 128c20.4 .6 39.8 8.9 54.3 23.4l35.6 35.6 7 7c0 0 0 0 0 0L219.9 397c6.2 6.2 16.4 6.2 22.6 0c1.7-1.7 3-3.7 3.7-5.8c2.8-7.7 9.3-13.5 17.3-15.3s16.4 .6 22.2 6.5L296.5 393c11.6 11.6 30.4 11.6 41.9 0c5.4-5.4 8.3-12.3 8.6-19.4c.4-8.8 5.6-16.6 13.6-20.4s17.3-3 24.4 2.1c9.4 6.7 22.5 5.8 30.9-2.6c9.4-9.4 9.4-24.6 0-33.9L340.1 243l-35.8 33c-27.3 25.2-69.2 25.6-97 .9c-31.7-28.2-32.4-77.4-1.6-106.5l70.1-66.2C303.2 78.4 339.4 64 377.1 64c36.1 0 71 13.3 97.9 37.2L505.1 128l38.9 0 40 0 40 0c8.8 0 16 7.2 16 16l0 208c0 17.7-14.3 32-32 32l-32 0c-11.8 0-22.2-6.4-27.7-16l-84.9 0c-3.4 6.7-7.9 13.1-13.5 18.7c-17.1 17.1-40.8 23.8-63 20.1c-3.6 7.3-8.5 14.1-14.6 20.2c-27.3 27.3-70 30-100.4 8.1c-25.1 20.8-62.5 19.5-86-4.1L159 404l-7-7-35.6-35.6c-5.5-5.5-12.7-8.7-20.4-9.3C96 369.7 81.6 384 64 384l-32 0c-17.7 0-32-14.3-32-32L0 144c0-8.8 7.2-16 16-16l40 0 40 0 19.8 0c2 0 3.9-.7 5.3-2l26.5-23.6C175.5 77.7 211.4 64 248.7 64L259 64c4.4 0 8.9 .2 13.2 .6zM544 320l0-144-48 0c-5.9 0-11.6-2.2-15.9-6.1l-36.9-32.8c-18.2-16.2-41.7-25.1-66.1-25.1c-25.4 0-49.8 9.7-68.3 27.1l-70.1 66.2c-10.3 9.8-10.1 26.3 .5 35.7c9.3 8.3 23.4 8.1 32.5-.3l71.9-66.4c9.7-9 24.9-8.4 33.9 1.4s8.4 24.9-1.4 33.9l-.8 .8 74.4 74.4c10 10 16.5 22.3 19.4 35.1l74.8 0zM64 336a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zm528 16a16 16 0 1 0 0-32 16 16 0 1 0 0 32z"
                                                                            fill="#6571FF" />
                                                                    </svg>
                                                                </div>
                                                                <div>
                                                                    <input
                                                                        class="form-check-input capture @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') input-margin @endif"
                                                                        type="radio" name="payment_mode"
                                                                        id="mercadoPagoPayment"
                                                                        value="mercado_pago_payment">
                                                                </div>
                                                            </div>
                                                            <h6 class="mb-0">{{ __('messages.mercado_pago') }}
                                                            </h6>
                                                            <p class="fs-14p mb-0">
                                                                {{ __('messages.pay_with_mercadopago') }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (isset($paymentTypes[4]))
                                            <div class="col-lg-3 p-2">
                                                <div class="mb-xxl-0 mb-4 border-radius" id="manuallyPayment">
                                                    <div class="selected-box ">
                                                        <label class="form-check input-padding">
                                                            <div class="d-flex gap-3 justify-content-between">
                                                                <div class=" mb-3">
                                                                    <svg width="60" height="60"
                                                                        viewBox="0 0 60 60" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M26.2117 37.1748C26.2117 37.4384 26.4213 37.6537 26.682 37.6537C26.9409 37.6537 27.1523 37.4402 27.1523 37.1748C27.1523 35.9498 25.9475 34.9706 24.3341 34.8092V34.3052C24.3341 34.0415 24.1245 33.8263 23.8638 33.8263C23.6049 33.8263 23.3935 34.0397 23.3935 34.3052V34.8092C21.7819 34.9706 20.5753 35.9499 20.5753 37.1748C20.5753 38.3997 21.7801 39.379 23.3935 39.5404V42.4064C22.3367 42.2683 21.5159 41.6801 21.5159 41.0003C21.5159 40.7367 21.3063 40.5214 21.0456 40.5214C20.7867 40.5214 20.5753 40.7349 20.5753 41.0003C20.5753 42.2253 21.7801 43.2045 23.3935 43.3659V43.8699C23.3935 44.1336 23.6031 44.3488 23.8638 44.3488C24.1227 44.3488 24.3341 44.1354 24.3341 43.8699V43.3659C25.9457 43.2045 27.1523 42.2252 27.1523 41.0003C27.1523 39.7754 25.9475 38.7961 24.3341 38.6347V35.7687C25.3909 35.9068 26.2117 36.495 26.2117 37.1748ZM21.5159 37.1748C21.5159 36.495 22.3385 35.9068 23.3953 35.7705V38.5791C22.3367 38.4428 21.5159 37.8545 21.5159 37.1748ZM26.2117 41.0003C26.2117 41.6801 25.3892 42.2683 24.3323 42.4046V39.596C25.3909 39.7341 26.2117 40.3206 26.2117 41.0003ZM23.8638 31.9145C19.9782 31.9145 16.8184 35.132 16.8184 39.0885C16.8184 43.0449 19.9782 46.2625 23.8638 46.2625C27.7494 46.2625 30.9093 43.0449 30.9093 39.0885C30.9093 35.132 27.7494 31.9145 23.8638 31.9145ZM23.8638 45.3047C20.4961 45.3047 17.7572 42.5158 17.7572 39.0866C17.7572 35.6574 20.4961 32.8685 23.8638 32.8685C27.2316 32.8685 29.9705 35.6574 29.9705 39.0866C29.9705 42.5158 27.2316 45.3047 23.8638 45.3047ZM44.8627 15.7928L37.3469 8.13989C37.2589 8.05022 37.1391 8 37.0158 8H16.3479C15.0533 8 14 9.0725 14 10.3907V49.6093C14 50.9275 15.0533 52 16.3479 52H42.6504C43.945 52 44.9982 50.9275 44.9982 49.6093L45 16.1318C45 16.0044 44.9508 15.8825 44.8627 15.7928ZM37.4845 9.63393L43.3972 15.6528H38.8934C38.1166 15.6528 37.4843 15.0089 37.4843 14.2179L37.4845 9.63393ZM42.6523 51.0439H16.3481C15.5713 51.0439 14.939 50.4001 14.939 49.6091V10.3924C14.939 9.60146 15.5713 8.95762 16.3481 8.95762H36.5457V14.2179C36.5457 15.5362 37.5989 16.6087 38.8935 16.6087H44.0596V49.6091C44.0614 50.4001 43.4291 51.0439 42.6523 51.0439ZM41.2432 43.8699C41.2432 44.1336 41.0336 44.3488 40.7729 44.3488H32.3184C32.0595 44.3488 31.8481 44.1354 31.8481 43.8699C31.8481 43.6063 32.0577 43.391 32.3184 43.391H40.7729C41.0319 43.3928 41.2432 43.6063 41.2432 43.8699ZM41.2432 39.0885C41.2432 39.3521 41.0336 39.5673 40.7729 39.5673L32.3184 39.5656C32.0595 39.5656 31.8481 39.3521 31.8481 39.0867C31.8481 38.823 32.0577 38.6078 32.3184 38.6078H40.7729C41.0319 38.6096 41.2432 38.823 41.2432 39.0885ZM41.2432 34.3052C41.2432 34.5688 41.0336 34.7841 40.7729 34.7841H32.3184C32.0595 34.7841 31.8481 34.5706 31.8481 34.3052C31.8481 34.0415 32.0577 33.8263 32.3184 33.8263H40.7729C41.0319 33.8263 41.2432 34.0415 41.2432 34.3052ZM41.2432 29.5219C41.2432 29.7855 41.0336 30.0008 40.7729 30.0008H18.2274C17.9685 30.0008 17.7572 29.7874 17.7572 29.5219C17.7572 29.2583 17.9668 29.043 18.2274 29.043H40.7729C41.0319 29.0448 41.2432 29.2582 41.2432 29.5219ZM41.2432 24.7404C41.2432 25.0041 41.0336 25.2193 40.7729 25.2193L18.2274 25.2175C17.9685 25.2175 17.7572 25.0041 17.7572 24.7387C17.7572 24.475 17.9668 24.2598 18.2274 24.2598H40.7729C41.0319 24.2616 41.2432 24.475 41.2432 24.7404ZM41.2432 19.9572C41.2432 20.2208 41.0336 20.436 40.7729 20.436H18.2274C17.9685 20.436 17.7572 20.2226 17.7572 19.9572C17.7572 19.6935 17.9668 19.4783 18.2274 19.4783H40.7729C41.0319 19.4783 41.2432 19.6935 41.2432 19.9572Z"
                                                                            fill="#6571FF" />
                                                                    </svg>
                                                                </div>
                                                                <div>
                                                                    <input
                                                                        class="form-check-input capture @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') input-margin @endif"
                                                                        type="radio" name="payment_mode"
                                                                        id="manualPayment" value="manual_payment">
                                                                </div>
                                                            </div>
                                                            <h6 class="mb-0"> {{ __('messages.manual_payments') }}</h6>
                                                            <p class="fs-14p mb-0">{{ __('messages.checks_crypto') }}</p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        {{-- @if (isset($paymentTypes[10]))
                                            <div class="col-lg-3 p-2">
                                                <div class="mb-xxl-0 mb-4 border-radius" id="sslcommerzPayment">
                                                    <div class="selected-box ">
                                                        <label class="form-check input-padding">
                                                            <div class="d-flex gap-3 justify-content-between">
                                                                <div class=" mb-3">
                                                                    <img src="{{ asset('assets/img/payment/sslcommerz-logo.png') }}"
                                                                        alt="sslcommerz" class="img-fluid sslcommerz-custom-icon mt-3">
                                                                </div>
                                                                <div>
                                                                    <input
                                                                        class="form-check-input capture @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') input-margin @endif "
                                                                        type="radio" name="payment_mode"
                                                                        id="sslcommerzPayment" value="sslcommerz_payment">
                                                                </div>
                                                            </div>
                                                            <h6 class="mb-0 mt-3">{{ __('messages.Sslcommerz') }}
                                                            </h6>
                                                            <p class="fs-14p mb-0">{{ __('messages.pay_with_sslcommerz') }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif --}}
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="flex-column mt-5 plan-controls">
                                        <div class="mt-5 me-3 w-sm-50 {{ $newPlan['amountToPay'] <= 0 ? 'd-none' : '' }}">
                                            <div class="mb-3 coupon-code-form d-none">
                                                <label
                                                    class="form-label fs-6 text-muted mb-0">{{ __('messages.coupon_code.have_a_coupon_code') }}</label>
                                                <div class="input-group">
                                                    {{ Form::text('coupon_code', null, ['class' => 'form-control', 'id' => 'paymentCouponCode', 'placeholder' => __('messages.coupon_code.enter_coupon_code')]) }}
                                                    <span
                                                        class="btn input-group-text bg-primary text-light disabled apply-coupon-code-btn"
                                                        id="applyCouponCodeBtn"
                                                        data-id="{{ $subscriptionsPricingPlan->id }}"
                                                        data-plan-price="{{ $subcriptionPrice }}">{{ __('messages.common.apply') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 switch-plan-btn  proceed-to-payment  d-none">
                                            <button type="button"
                                                class="btn btn-primary rounded-pill mx-auto d-block makePayment"
                                                data-id="{{ $subscriptionsPricingPlan->id }}"
                                                data-plan-price="{{ $subcriptionPrice }}">
                                                {{ __('messages.subscription.pay_or_switch_plan') }}</button>
                                        </div>
                                        <div
                                            class="mt-5 stripePayment proceed-to-payment {{ $amountTopay > 0 ? 'd-none' : '' }}">
                                            <button type="button"
                                                class="btn btn-primary rounded-pill mx-auto d-block makePayment"
                                                data-id="{{ $subscriptionsPricingPlan->id }}"
                                                data-plan-price="{{ $subcriptionPrice }}">
                                                {{ __('messages.subscription.pay_or_switch_plan') }}</button>
                                        </div>
                                        <div class="mt-5 paypalPayment proceed-to-payment d-none">
                                            <button type="button"
                                                class="btn btn-primary rounded-pill mx-auto d-block paymentByPaypal"
                                                data-id="{{ $subscriptionsPricingPlan->id }}"
                                                data-plan-price="{{ $subcriptionPrice }}">
                                                {{ __('messages.subscription.pay_or_switch_plan') }}</button>
                                        </div>
                                        <div class="mt-5 RazorPayPayment proceed-to-payment d-none">
                                            <button type="button"
                                                class="btn btn-primary rounded-pill mx-auto d-block paymentByRazorPay"
                                                data-id="{{ $subscriptionsPricingPlan->id }}"
                                                data-plan-price="{{ $subcriptionPrice }}">
                                                {{ __('messages.subscription.pay_or_switch_plan') }}</button>
                                        </div>
                                        <div class="mt-5 paystackPayment proceed-to-payment d-none">
                                            <button type="button"
                                                class="btn btn-primary rounded-pill mx-auto d-block paymentBypaystack"
                                                data-id="{{ $subscriptionsPricingPlan->id }}"
                                                data-plan-price="{{ $subcriptionPrice }}">
                                                {{ __('messages.subscription.pay_or_switch_plan') }}</button>
                                        </div>
                                        <div class="mt-5 flutterwavePayment proceed-to-payment d-none">
                                            <button type="button"
                                                class="btn btn-primary rounded-pill mx-auto d-block paymentByflutterwave"
                                                data-id="{{ $subscriptionsPricingPlan->id }}"
                                                data-plan-price="{{ $subcriptionPrice }}">
                                                {{ __('messages.subscription.pay_or_switch_plan') }}</button>
                                        </div>
                                        <div class="mt-5 phonepePayment proceed-to-payment d-none">
                                            <button type="button"
                                                class="btn btn-primary rounded-pill mx-auto d-block paymentByPhonepe"
                                                data-id="{{ $subscriptionsPricingPlan->id }}"
                                                data-plan-price="{{ $subcriptionPrice }}">
                                                {{ __('messages.subscription.pay_or_switch_plan') }}</button>
                                        </div>
                                        <div class="mt-5 mercadoPagoPayment proceed-to-payment d-none">
                                            <button type="button"
                                                class="btn btn-primary rounded-pill mx-auto d-block paymentByMercadoPago"
                                                data-id="{{ $subscriptionsPricingPlan->id }}"
                                                data-plan-price="{{ $subcriptionPrice }}">
                                                {{ __('messages.subscription.pay_or_switch_plan') }}</button>
                                        </div>
                                        <div class="mt-5 payfastPayment proceed-to-payment d-none">
                                            <button type="button"
                                                class="btn btn-primary rounded-pill mx-auto d-block paymentByPayfast"
                                                data-id="{{ $subscriptionsPricingPlan->id }}"
                                                data-plan-price="{{ $subcriptionPrice }}">
                                                {{ __('messages.subscription.pay_or_switch_plan') }}</button>
                                        </div>
                                        {{-- <div class="mt-5 sslcommerzPayment proceed-to-payment d-none">
                                            <button type="button"
                                                class="btn btn-primary rounded-pill mx-auto d-block paymentBySslcommerz"
                                                data-id="{{ $subscriptionsPricingPlan->id }}"
                                                data-plan-price="{{ $subcriptionPrice }}">
                                                {{ __('messages.subscription.pay_or_switch_plan') }}</button>
                                        </div> --}}

                                        <div class="mt-5 iyzicoPayment proceed-to-payment d-none">
                                            <button type="button"
                                                class="btn btn-primary rounded-pill mx-auto d-block paymentByIyzico"
                                                data-id="{{ $subscriptionsPricingPlan->id }}"
                                                data-plan-price="{{ $subcriptionPrice }}">
                                                {{ __('messages.subscription.pay_or_switch_plan') }}</button>
                                        </div>

                                    </div>
                                </div>
                                <div class="">
                                    <div class="mt-5 plan-controls">
                                        <div class="bg-light">
                                            <div class="row">
                                                <div class="col-3">
                                                    <h1 class="ps-5 py-5 d-none manual-payment-guide">
                                                        {{ __('messages.vcard.manual_payment_guide') }}
                                                        :-</h1>
                                                </div>
                                                <div class="col-lg-9">
                                                    @if (getSuperAdminSettingValue('is_manual_payment_guide_on'))
                                                        <div class="d-none plan-controls manuallyPayAttachment py-5 pe-4">
                                                            {!! getSuperAdminSettingValue('manual_payment_guide') !!}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <form class="manuallyPaymentForm" type="post" enctype="multipart/form-data">
                                            <div class="mb-3 d-none manuallyPayAttachment me-5 mt-5"
                                                io-image-input="true">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-md-6 col-lg-4 col-xxl-3">
                                                            </div>
                                                            <div class="col-md-3 col-lg-2 col-xxl-1 attachment-field">
                                                                <label for="exampleInputImage"
                                                                    class="form-label">{{ __('messages.mail.attachment') }}
                                                                    :-</label>
                                                                <div class="d-block">
                                                                    <div class="image-picker">
                                                                        <div class="image previewImage"
                                                                            id="exampleInputImage"
                                                                            style="background-image: url('{{ asset('assets/images/cover_image1.png') }}')">
                                                                        </div>
                                                                        <span
                                                                            class="picker-edit rounded-circle text-gray-500 fs-small"
                                                                            data-bs-toggle="tooltip" data-placement="top"
                                                                            data-bs-original-title="Choose Attachment">
                                                                            <label>
                                                                                <i class="fa-solid fa-pen"
                                                                                    id="profileImageIcon"></i>
                                                                                <input type="file"
                                                                                    id="manual_payment_attachment"
                                                                                    name="attachment"
                                                                                    class="image-upload file-validation d-none crop-image-input"
                                                                                    accept="image/*" data-preview-id="subscription_manual_payment_attachment" />
                                                                            </label>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-9 col-xxl-4">
                                                                <label for="exampleInputImage"
                                                                    class="form-label">{{ __('messages.mail.notes') }}
                                                                    :-</label>
                                                                {{ Form::textarea('notes', null, ['class' => 'form-control', 'placeholder' => __('messages.form.add_your_note'), 'rows' => '5']) }}
                                                            </div>

                                                        </div>
                                                    </div>
                                                    {{ Form::hidden('customPlanPrice', isset($customField) ? $customField->id : null, ['id' => 'customFieldId']) }}
                                                    {{ Form::hidden('planId', $subscriptionsPricingPlan->id, ['id' => 'planId', 'class' => 'manuallyPaymentPlanId']) }}
                                                    {{ Form::hidden('price', $subcriptionPrice, ['id' => 'price', 'class' => 'manuallyPaymentDataPlanPrice']) }}
                                                    {{ Form::hidden('currency_icon', $subscriptionsPricingPlan->currency->currency_icon, ['id' => 'currencyIcon', 'class' => 'currencyIcon']) }}
                                                    {{ Form::hidden('amount_to_pay', $newPlan['amountToPay'], ['id' => 'amountToPay']) }}
                                                    {{ Form::hidden('couponCode', null, ['id' => 'couponCode']) }}
                                                    {{ Form::hidden('couponCodeId', null, ['id' => 'couponCodeId']) }}
                                                    {{ Form::hidden('plan_end_date', $newPlan['endDate'], ['id' => 'planEndDate']) }}
                                                    {{ Form::hidden('payment_type', 4, ['id' => 'payment_type']) }}
                                                    {{ Form::hidden('tenant_id', getLogInTenantId(), ['id' => 'tenantId']) }}
                                                    <div class="col-lg-12">
                                                        <div class="mt-5 ManuallyPayment proceed-to-payment d-none">
                                                            <button type="submit"
                                                                class="btn btn-primary rounded-pill mx-auto d-block manuallyPay">
                                                                {{ __('messages.subscription.cash_pay') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushOnce('scripts')
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        let mercadoPagoPublicKey = new MercadoPago("{{ getSelectedPaymentGateway('mp_public_key') }}");
    </script>
    <script>
        let options = {
            'key': "{{ getSelectedPaymentGateway('razorpay_key') }}",
            'amount': 0, //  100 refers to 1
            'currency': 'INR',
            'name': "{{ getAppName() }}",
            'order_id': '',
            'description': '',
            'image': '{{ asset(getAppLogo()) }}', // logo here
            'callback_url': "{{ route('razorpay.success') }}",
            'prefill': {
                'email': '', // recipient email here
                'name': '', // recipient name here
                'contact': '', // recipient phone here
            },
            'readonly': {
                'name': 'true',
                'email': 'true',
                'contact': 'true',
            },
            'theme': {
                'color': '#0ea6e9',
            },
            'modal': {
                'ondismiss': function() {
                    $('#paymentGatewayModal').modal('hide');
                    displayErrorMessage(Lang.get('js.payment_not_complete'));
                    setTimeout(function() {
                        Turbo.visit(window.location.href);
                    }, 1000);
                },
            },
        };
    </script>
@endPushOnce
