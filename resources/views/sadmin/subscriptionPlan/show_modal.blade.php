<div class="modal fade common-modal-card" id="showSubscriptionModal" tabindex="-1" aria-labelledby="showSubscriptionModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.subscription.subscribed_plan_details') }}</h5>
                <button type="button" class="modal-close p-0 border-0 bg-transparent @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') m-0 @endif" data-bs-dismiss="modal" aria-label="Close">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Menu / Close_MD"> <path id="Vector" d="M18 18L12 12M12 12L6 6M12 12L18 6M12 12L6 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div>
                    <div class="row py-3">
                        <h5 class="col-5 mb-0">{{ __('messages.vcard.user_name') }} </h5>
                        <div class="col-7">: <span id="subscriptionUserName"></span></div>
                    </div>
                    <div class="row py-3">
                        <h5 class="col-5 mb-0">{{ __('messages.subscription.plan_name') }} </h5>
                        <div class="col-7">: <span id="subscriptionPlanName"></span></div>
                    </div>
                    <div class="row py-3">
                        <h5 class="col-5 mb-0">{{ __('messages.subscription.plan_price') }} </h5>
                        <div class="col-7">: <span id="subscriptionPlanPrice"></span></div>
                    </div>
                    <div class="coupon-data-div d-none">
                        <div class="row py-3">
                            <h5 class="col-5 mb-0">{{ __('messages.coupon_code.coupon_name') }} </h5>
                            <div class="col-7">: <span id="subscriptionCouponName"></span></div>
                        </div>
                        <div class="row py-3">
                            <h5 class="col-5 mb-0">{{ __('messages.coupon_code.coupon_discount') }} </h5>
                            <div class="col-7">: <span id="subscriptionCouponDiscount"></span></div>
                        </div>
                    </div>
                    <div id="settings" data-value="{{ getSuperAdminSettingValue('hide_decimal_values') }}">
                    </div>
                    <div class="row py-3">
                        <h5 class="col-5 mb-0">{{ __('messages.subscription.payable_amount') }} </h5>
                        <div class="col-7">: <span id="subscriptionPayableAmount"></span></div>
                    </div>
                    <div class="row py-3">
                        <h5 class="col-5 mb-0">{{ __('messages.payment_type') }} </h5>
                        <div class="col-7">: <span id="subscriptionPaymentType"></span></div>
                    </div>
                    <div class="row py-3">
                        <h5 class="col-5 mb-0">{{ __('messages.subscription.end_date') }} </h5>
                        <div class="col-7">: <span id="subscriptionEndDate"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
