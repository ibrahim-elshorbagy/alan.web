@extends('settings.edit')
@section('section')
    <div class="card card-payment w-100">
        <div class="card-body d-md-flex">
            @include('settings.setting_menu')
            <div class="w-100">
                <div class="card-header px-0">
                    <div class="d-flex align-items-center justify-content-center">
                        <h3 class="m-0">{{ __('messages.payment_method') }}</h3>
                    </div>
                </div>
                <div class="card-body border-top p-3">
                    {{ Form::open(['route' => ['payment.method.update'], 'method' => 'post', 'id' => 'SuperAdminCredentialsSettings']) }}

                    <div class="row mb-4">
                        <!-- Stripe Card -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-3 p-md-4">
                                    <div
                                        class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center mb-2 mb-sm-0">
                                            <div class="me-2">
                                                <svg width="60" height="60" viewBox="0 0 100 100" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
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
                                                            <rect width="100" height="100" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <h6 class="mb-0 fw-bold">{{ __('messages.setting.stripe') }}</h6>
                                        </div>
                                        <label class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ \App\Models\Plan::STRIPE }}"
                                                name="payment_gateway[{{ \App\Models\Plan::STRIPE }}]"
                                                {{ isset($selectedPaymentGateways['Stripe']) ? 'checked' : '' }}
                                                id="stripe_payment">
                                        </label>
                                    </div>
                                    <div
                                        class="stripe-cred {{ !isset($selectedPaymentGateways['Stripe']) ? 'd-none' : '' }}">
                                        <div class="mb-3">
                                            {{ Form::label('stripe_key', __('messages.setting.stripe_key') . ':', ['class' => 'form-label mb-2 required fs-7']) }}
                                            <div class="position-relative">
                                                {{ Form::input(isset($setting['stripe_key']) ?? null ? 'password' : 'text', 'stripe_key', $setting['stripe_key'] ?? null, ['class' => 'form-control form-control-sm stripe-key ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.stripe_key'), 'data-toggle' => 'password']) }}
                                                <span
                                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                    <i class="bi bi-eye-slash-fill fs-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            {{ Form::label('stripe_secret', __('messages.setting.stripe_secret') . ':', ['class' => 'form-label stripe-secret-label mb-2 required fs-7']) }}
                                            <div class="position-relative">
                                                {{ Form::input(isset($setting['stripe_secret']) ?? null ? 'password' : 'text', 'stripe_secret', $setting['stripe_secret'] ?? null, ['class' => 'form-control form-control-sm stripe-secret ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.stripe_secret'), 'data-toggle' => 'password']) }}
                                                <span
                                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                    <i class="bi bi-eye-slash-fill fs-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Razorpay Card -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-3 p-md-4">
                                    <div
                                        class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center mb-2 mb-sm-0">
                                            <div class="me-2">
                                                <svg width="60" height="60" viewBox="0 0 100 100" fill="none"
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
                                                        <path d="M28.4391 49.22L25 62H42.0272L51 32L28.4391 49.22Z"
                                                            fill="#6571FF" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_31_5">
                                                            <rect width="100" height="100" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <h6 class="mb-0 fw-bold">{{ __('messages.setting.razorpay') }}</h6>
                                        </div>
                                        <label class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ \App\Models\Plan::RAZORPAY }}"
                                                name="payment_gateway[{{ \App\Models\Plan::RAZORPAY }}]"
                                                id="razorpay_payment"
                                                {{ isset($selectedPaymentGateways['Razorpay']) ? 'checked' : '' }}>
                                        </label>
                                    </div>
                                    <div
                                        class="razorpay-cred {{ !isset($selectedPaymentGateways['Razorpay']) ? 'd-none' : '' }}">
                                        <div class="mb-3">
                                            {{ Form::label('razorpay_key', __('messages.setting.razorpay_key') . ':', ['class' => 'form-label razorpay-key-label mb-2 required fs-7']) }}
                                            <div class="position-relative">
                                                {{ Form::input(isset($setting['razorpay_key']) ?? null ? 'password' : 'text', 'razorpay_key', $setting['razorpay_key'] ?? null, ['class' => 'form-control form-control-sm razorpay-key ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.razorpay_key'), 'data-toggle' => 'password']) }}
                                                <span
                                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                    <i class="bi bi-eye-slash-fill fs-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            {{ Form::label('razorpay_secret', __('messages.setting.razorpay_secret') . ':', ['class' => 'form-label razorpay-secret-label mb-2 required fs-7']) }}
                                            <div class="position-relative">
                                                {{ Form::input(isset($setting['razorpay_secret']) ?? null ? 'password' : 'text', 'razorpay_secret', $setting['razorpay_secret'] ?? null, ['class' => 'form-control form-control-sm razorpay-secret ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.razorpay_secret'), 'data-toggle' => 'password']) }}
                                                <span
                                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                    <i class="bi bi-eye-slash-fill fs-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Paystack Card -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-3 p-md-4">
                                    <div
                                        class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center mb-2 mb-sm-0">
                                            <div class="me-2">
                                                <svg class="mt-2 mb-2" width="12" height="14"
                                                    style="width: 45px; height: 45px" viewBox="0 0 15 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12.8097 1.515H0.749985C0.344993 1.515 0 1.85999 0 2.27998V3.64495C0 4.06494 0.344993 4.40994 0.749985 4.40994H12.8097C13.2297 4.40994 13.5597 4.06494 13.5747 3.64495V2.29498C13.5747 1.85999 13.2297 1.515 12.8097 1.515ZM12.8097 9.08984H0.749985C0.554989 9.08984 0.359993 9.16484 0.224995 9.31484C0.0749984 9.46483 0 9.64483 0 9.85482V11.2198C0 11.6398 0.344993 11.9848 0.749985 11.9848H12.8097C13.2297 11.9848 13.5597 11.6548 13.5747 11.2198V9.85482C13.5597 9.41983 13.2297 9.08984 12.8097 9.08984ZM7.54484 12.8698H0.749985C0.554989 12.8698 0.359993 12.9448 0.224995 13.0948C0.0899981 13.2448 0 13.4248 0 13.6347V14.9997C0 15.4197 0.344993 15.7647 0.749985 15.7647H7.52984C7.94984 15.7647 8.27983 15.4197 8.27983 15.0147V13.6497C8.29483 13.1998 7.96484 12.8698 7.54484 12.8698ZM13.5747 5.29492H0.749985C0.554989 5.29492 0.359993 5.36992 0.224995 5.51991C0.0899981 5.66991 0 5.84991 0 6.0599V7.42488C0 7.84487 0.344993 8.18986 0.749985 8.18986H13.5597C13.9797 8.18986 14.3097 7.84487 14.3097 7.42488V6.0599C14.3247 5.65491 13.9797 5.30992 13.5747 5.29492Z"
                                                        fill="#6571FF" />
                                                </svg>
                                            </div>
                                            <h6 class="mb-0 fw-bold">{{ __('messages.setting.paystack') }}</h6>
                                        </div>
                                        <label class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ \App\Models\Plan::PAYSTACK }}"
                                                name="payment_gateway[{{ \App\Models\Plan::PAYSTACK }}]"
                                                {{ isset($selectedPaymentGateways['Paystack']) ? 'checked' : '' }}
                                                id="paystack_payment">
                                        </label>
                                    </div>
                                    <div
                                        class="paystack-cred {{ !isset($selectedPaymentGateways['Paystack']) ? 'd-none' : '' }}">
                                        <div class="mb-3">
                                            {{ Form::label('paystack_key', __('messages.setting.paystack_key') . ':', ['class' => 'form-label mb-2 required fs-7']) }}
                                            <div class="position-relative">
                                                {{ Form::input(isset($setting['paystack_key']) ?? null ? 'password' : 'text', 'paystack_key', $setting['paystack_key'] ?? null, ['class' => 'form-control form-control-sm paystack-key ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.paystack_key'), 'data-toggle' => 'password']) }}
                                                <span
                                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                    <i class="bi bi-eye-slash-fill fs-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            {{ Form::label('paystack_secret', __('messages.setting.paystack_secret') . ':', ['class' => 'form-label stripe-secret-label mb-2 required fs-7']) }}
                                            <div class="position-relative">
                                                {{ Form::input(isset($setting['paystack_secret']) ?? null ? 'password' : 'text', 'paystack_secret', $setting['paystack_secret'] ?? null, ['class' => 'form-control form-control-sm paystack-secret ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.paystack_secret'), 'data-toggle' => 'password']) }}
                                                <span
                                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                    <i class="bi bi-eye-slash-fill fs-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="text-muted fs-10">{{ new Illuminate\Support\HtmlString(__('messages.setting.paystack_callback_url_note')) }}</br> {{ route('paystack.success') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Flutterwave Card -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-3 p-md-4">
                                    <div
                                        class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center mb-2 mb-sm-0">
                                            <div class="me-2">
                                                <svg class="custom-icon mt-2 mb-2" width="17" height="17"
                                                    viewBox="0 0 17 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12.1407 0.133175C19.6913 -1.00085 14.8537 5.43009 12.5139 7.23879C14.1216 8.4733 15.7724 10.2102 16.4758 12.1768C17.7821 15.7799 14.5666 16.311 12.1407 15.4067C9.48502 14.4736 7.14519 12.4783 5.59487 10.1385C5.16423 10.1385 4.69052 10.0667 4.24552 9.93748C5.12117 12.4065 5.49439 14.9329 5.25036 17C5.25036 12.8372 3.2694 8.70297 0.412801 5.25783C-0.592034 4.05203 0.441509 3.16203 1.34586 4.32477C1.96312 5.1717 2.52295 6.04734 3.02537 6.95169C4.01585 3.56397 8.83905 0.606882 12.1407 0.133175ZM11.064 6.26266C12.5426 5.35831 17.0356 0.535109 12.844 0.965752C10.4324 1.23849 7.50406 3.46348 6.29826 4.89896C7.97777 4.69799 9.68598 5.43009 11.064 6.26266ZM6.90116 10.0093C8.25051 11.5165 10.0879 12.9807 12.0689 13.5118C13.2173 13.8133 14.4805 13.6841 14.0211 12.0476C13.5474 10.5404 12.3416 9.21975 11.1645 8.21491C10.8344 8.44459 10.4611 8.68862 10.0879 8.84652C9.08308 9.40636 8.00648 9.80829 6.90116 10.0093Z"
                                                        fill="#6571FF" />
                                                    <path
                                                        d="M6.25536 5.96117C7.40374 5.86069 8.63825 6.46359 9.58567 7.06649C8.68132 7.49713 7.67648 7.76987 6.62858 7.82729C5.09262 7.84165 4.77682 6.10472 6.25536 5.96117Z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                            <h6 class="mb-0 fw-bold">{{ __('messages.setting.flutterwave') }}</h6>
                                        </div>
                                        <label class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ \App\Models\Plan::FLUTTERWAVE }}"
                                                name="payment_gateway[{{ \App\Models\Plan::FLUTTERWAVE }}]"
                                                id="flutterwave_payment"
                                                {{ isset($selectedPaymentGateways['Flutterwave']) ? 'checked' : '' }}>
                                        </label>
                                    </div>
                                    <div
                                        class="flutterwave-cred {{ !isset($selectedPaymentGateways['Flutterwave']) ? 'd-none' : '' }}">
                                        <div class="mb-3">
                                            {{ Form::label('flutterwave_key', __('messages.setting.flutterwave_key') . ':', ['class' => 'form-label razorpay-key-label mb-2 required fs-7']) }}
                                            <div class="position-relative">
                                                {{ Form::input(isset($setting['flutterwave_key']) ?? null ? 'password' : 'text', 'flutterwave_key', $setting['flutterwave_key'] ?? null, ['class' => 'form-control form-control-sm flutterwave-key ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.flutterwave_key'), 'data-toggle' => 'password']) }}
                                                <span
                                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                    <i class="bi bi-eye-slash-fill fs-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            {{ Form::label('flutterwave_secret', __('messages.setting.flutterwave_secret') . ':', ['class' => 'form-label razorpay-secret-label mb-2 required fs-7']) }}
                                            <div class="position-relative">
                                                {{ Form::input(isset($setting['flutterwave_secret']) ?? null ? 'password' : 'text', 'flutterwave_secret', $setting['flutterwave_secret'] ?? null, ['class' => 'form-control form-control-sm flutterwave-secret ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.flutterwave_secret'), 'data-toggle' => 'password']) }}
                                                <span
                                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                    <i class="bi bi-eye-slash-fill fs-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <!-- PhonePe Card -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-3 p-md-4">
                                    <div
                                        class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center mb-2 mb-sm-0">
                                            <div class="me-1">
                                                <svg width="60" height="60" viewBox="0 0 100 100" fill="none"
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
                                                            <rect width="100" height="100" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <h6 class="mb-0 fw-bold">{{ __('messages.setting.phonepe') }}</h6>
                                        </div>
                                        <label class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ \App\Models\Plan::PHONEPE }}"
                                                name="payment_gateway[{{ \App\Models\Plan::PHONEPE }}]"
                                                {{ isset($selectedPaymentGateways['PhonePe']) ? 'checked' : '' }}
                                                id="phonepe_payment">
                                        </label>
                                    </div>
                                    <div
                                        class="phonepe-cred {{ !isset($selectedPaymentGateways['PhonePe']) ? 'd-none' : '' }}">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                {{ Form::label('phonepe_merchant_id', __('messages.setting.phonepe_merchant_id') . ':', ['class' => 'form-label mb-2 required fs-7']) }}
                                                <div class="position-relative">
                                                    {{ Form::input(isset($setting['phonepe_merchant_id']) ?? null ? 'password' : 'text', 'phonepe_merchant_id', $setting['phonepe_merchant_id'], ['class' => 'form-control form-control-sm phonepe_merchant_id ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.phonepe_merchant_id'), 'data-toggle' => 'password']) }}
                                                    <span
                                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                        <i class="bi bi-eye-slash-fill fs-7"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                {{ Form::label('phonepe_merchant_user_id', __('messages.setting.phonepe_merchant_user_id') . ':', ['class' => 'form-label stripe-secret-label mb-2 required fs-7']) }}
                                                <div class="position-relative">
                                                    {{ Form::input(isset($setting['phonepe_merchant_user_id']) ?? null ? 'password' : 'text', 'phonepe_merchant_user_id', $setting['phonepe_merchant_user_id'], ['class' => 'form-control form-control-sm phonepe_merchant_user_id ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.phonepe_merchant_user_id'), 'data-toggle' => 'password']) }}
                                                    <span
                                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                        <i class="bi bi-eye-slash-fill fs-7"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                {{ Form::label('phonepe_env', __('messages.setting.phonepe_env') . ':', ['class' => 'form-label mb-2 required fs-7']) }}
                                                <div class="position-relative">
                                                    {{ Form::input(isset($setting['phonepe_env']) ?? null ? 'password' : 'text', 'phonepe_env', $setting['phonepe_env'], ['class' => 'form-control form-control-sm phonepe_env ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.phonepe_env'), 'data-toggle' => 'password']) }}
                                                    <span
                                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                        <i class="bi bi-eye-slash-fill fs-7"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                {{ Form::label('phonepe_salt_key', __('messages.setting.phonepe_salt_key') . ':', ['class' => 'form-label stripe-secret-label mb-2 required fs-7']) }}
                                                <div class="position-relative">
                                                    {{ Form::input(isset($setting['phonepe_salt_key']) ?? null ? 'password' : 'text', 'phonepe_salt_key', $setting['phonepe_salt_key'], ['class' => 'form-control form-control-sm phonepe_salt_key ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.phonepe_salt_key'), 'data-toggle' => 'password']) }}
                                                    <span
                                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                        <i class="bi bi-eye-slash-fill fs-7"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-0">
                                                {{ Form::label('phonepe_salt_index', __('messages.setting.phonepe_salt_index') . ':', ['class' => 'form-label mb-2 required fs-7']) }}
                                                <div class="position-relative">
                                                    {{ Form::input(isset($setting['phonepe_salt_index']) ?? null ? 'password' : 'text', 'phonepe_salt_index', $setting['phonepe_salt_index'], ['class' => 'form-control form-control-sm phonepe_salt_index ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.phonepe_salt_index'), 'data-toggle' => 'password']) }}
                                                    <span
                                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                        <i class="bi bi-eye-slash-fill fs-7"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PayFast Card -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-3 p-md-4">
                                    <div
                                        class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center mb-2 mb-sm-0">
                                            <div class="me-2">
                                                <img src="{{ asset('images/payfast-logo.svg') }}" height="45"
                                                    width="90" alt="PayFast">
                                            </div>
                                            <h6 class="mb-0 fw-bold">{{ __('messages.setting.payfast') }}</h6>
                                        </div>
                                        <label class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ \App\Models\Plan::PAYFAST }}"
                                                name="payment_gateway[{{ \App\Models\Plan::PAYFAST }}]"
                                                id="payfast_payment"
                                                {{ isset($selectedPaymentGateways['Payfast']) ? 'checked' : '' }}>
                                        </label>
                                    </div>
                                    <div
                                        class="payfast-cred {{ !isset($selectedPaymentGateways['Payfast']) ? 'd-none' : '' }}">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                {{ Form::label('payfast_merchant_id', __('messages.setting.payfast_merchant_id') . ':', ['class' => 'form-label payfast-client-id-label mb-2 required fs-7']) }}
                                                <div class="position-relative">
                                                    {{ Form::input(isset($setting['payfast_merchant_id']) ?? null ? 'password' : 'text', 'payfast_merchant_id', $setting['payfast_merchant_id'] ?? null, ['class' => 'form-control form-control-sm ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.payfast_merchant_id'), 'data-toggle' => 'password']) }}
                                                    <span
                                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                        <i class="bi bi-eye-slash-fill fs-7"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                {{ Form::label('payfast_merchant_key', __('messages.setting.payfast_merchant_key') . ':', ['class' => 'form-label payfast-secret-label mb-2 required fs-7']) }}
                                                <div class="position-relative">
                                                    {{ Form::input(isset($setting['payfast_merchant_key']) ?? null ? 'password' : 'text', 'payfast_merchant_key', $setting['payfast_merchant_key'] ?? null, ['class' => 'form-control form-control-sm ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.payfast_merchant_key'), 'data-toggle' => 'password']) }}
                                                    <span
                                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                        <i class="bi bi-eye-slash-fill fs-7"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                {{ Form::label('payfast_passphrase_key', __('messages.setting.passphrase_key') . ':', ['class' => 'form-label mb-2 required fs-7']) }}
                                                <div class="position-relative">
                                                    {{ Form::input(isset($setting['payfast_passphrase_key']) ?? null ? 'password' : 'text', 'payfast_passphrase_key', $setting['payfast_passphrase_key'] ?? null, ['class' => 'form-control form-control-sm ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.passphrase_key'), 'data-toggle' => 'password']) }}
                                                    <span
                                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                        <i class="bi bi-eye-slash-fill fs-7"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-0">
                                                {{ Form::label('payfast_mode', __('messages.setting.payfast_mode') . ':', ['class' => 'form-label mb-2 required fs-7']) }}
                                                {{ Form::select('payfast_mode', $payfastMode, $setting['payfast_mode'] ?? null, ['class' => 'form-control form-control-sm', 'data-control' => 'select2', 'data-minimum-results-for-search' => 'Infinity']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <!-- PayPal Card -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-3 p-md-4">
                                    <div
                                        class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center mb-2 mb-sm-0">
                                            <div class="">
                                                <svg width="60" height="60" viewBox="0 0 100 100" fill="none"
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
                                                            <rect width="100" height="100" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <h6 class="mb-0 fw-bold">{{ __('messages.setting.paypal') }}</h6>
                                        </div>
                                        <label class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ \App\Models\Plan::PAYPAL }}"
                                                name="payment_gateway[{{ \App\Models\Plan::PAYPAL }}]"
                                                id="paypal_payment"
                                                {{ isset($selectedPaymentGateways['Paypal']) ? 'checked' : '' }}>
                                        </label>
                                    </div>
                                    <div
                                        class="paypal-cred {{ !isset($selectedPaymentGateways['Paypal']) ? 'd-none' : '' }}">
                                        <div class="mb-3">
                                            {{ Form::label('paypal_client_id', __('messages.setting.paypal_client_id') . ':', ['class' => 'form-label paypal-client-id-label mb-2 required fs-7']) }}
                                            <div class="position-relative">
                                                {{ Form::input(isset($setting['paypal_client_id']) ?? null ? 'password' : 'text', 'paypal_client_id', $setting['paypal_client_id'] ?? null, ['class' => 'form-control form-control-sm paypal-client-id ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.paypal_client_id'), 'data-toggle' => 'password']) }}
                                                <span
                                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                    <i class="bi bi-eye-slash-fill fs-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            {{ Form::label('paypal_secret', __('messages.setting.paypal_secret') . ':', ['class' => 'form-label paypal-secret-label mb-2 required fs-7']) }}
                                            <div class="position-relative">
                                                {{ Form::input(isset($setting['paypal_secret']) ?? null ? 'password' : 'text', 'paypal_secret', $setting['paypal_secret'] ?? null, ['class' => 'form-control form-control-sm paypal-secret ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.paypal_secret'), 'data-toggle' => 'password']) }}
                                                <span
                                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                    <i class="bi bi-eye-slash-fill fs-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            {{ Form::label('paypal_mode', __('messages.setting.paypal_mode') . ':', ['class' => 'form-label paypal-secret-label mb-2 required fs-7']) }}
                                            {{ Form::select('paypal_mode', $paypalMode, $setting['paypal_mode'], ['class' => 'form-control form-control-sm paypal-secret', 'data-control' => 'select2', 'data-minimum-results-for-search' => 'Infinity']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Iyzico Card -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-3 p-md-4">
                                    <div
                                        class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center mb-2 mb-sm-0">
                                            <div class="me-2">
                                                <img src="{{ asset('images/iyzico.png') }}" class="custom-icon mt-2 mb-2"
                                                    alt="iyzico">
                                            </div>
                                            <h6 class="mb-0 fw-bold">{{ __('messages.setting.iyzico') }}</h6>
                                        </div>
                                        <label class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ \App\Models\Plan::IYZICO }}"
                                                name="payment_gateway[{{ \App\Models\Plan::IYZICO }}]"
                                                {{ isset($selectedPaymentGateways['Iyzico']) ? 'checked' : '' }}
                                                id="iyzico_payment">
                                        </label>
                                    </div>
                                    <div
                                        class="iyzico-cred {{ !isset($selectedPaymentGateways['Iyzico']) ? 'd-none' : '' }}">
                                        <div class="mb-3">
                                            {{ Form::label('iyzico_key', __('messages.setting.iyzico_key') . ':', ['class' => 'form-label mb-2 required fs-7']) }}
                                            <div class="position-relative">
                                                {{ Form::input(isset($setting['iyzico_key']) ?? null ? 'password' : 'text', 'iyzico_key', $setting['iyzico_key'] ?? null, ['class' => 'form-control form-control-sm iyzico-key ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.iyzico_key'), 'data-toggle' => 'password']) }}
                                                <span
                                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                    <i class="bi bi-eye-slash-fill fs-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            {{ Form::label('iyzico_secret', __('messages.setting.iyzico_secret') . ':', ['class' => 'form-label iyzico-secret-label mb-2 required fs-7']) }}
                                            <div class="position-relative">
                                                {{ Form::input(isset($setting['iyzico_secret']) ?? null ? 'password' : 'text', 'iyzico_secret', $setting['iyzico_secret'] ?? null, ['class' => 'form-control form-control-sm iyzico-secret ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.iyzico_secret'), 'data-toggle' => 'password']) }}
                                                <span
                                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                    <i class="bi bi-eye-slash-fill fs-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            {{ Form::label('iyzico_mode', __('messages.setting.iyzico_mode') . ':', ['class' => 'form-label iyzico-secret-label mb-2 required fs-7']) }}
                                            {{ Form::select('iyzico_mode', $iyzicoMode, $setting['iyzico_mode'] ?? null, ['class' => 'form-control form-control-sm iyzico-secret', 'data-control' => 'select2', 'data-minimum-results-for-search' => 'Infinity']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sslcommerz section start --}}

                        {{-- <div class="">
                        <div class="form-group mb-5 mt-10">
                            <label class="form-check form-switch form-check-custom ">
                                <input class="form-check-input" type="checkbox" value="{{ \App\Models\Plan::SSLCOMMERZ }}"
                                    name="payment_gateway[{{ \App\Models\Plan::SSLCOMMERZ }}]" id="sslcommerz_payment"
                                    {{ isset($selectedPaymentGateways['Sslcommerz']) ? 'checked' : '' }}>
                                <span class="form-check-label fw-bold"
                                    for="flexSwitchCheckDefault">{{ __('messages.Sslcommerz') }}</span>&nbsp;&nbsp;
                            </label>
                        </div>
                        <div
                            class="col-lg-10 row sslcommerz-cred {{ !isset($selectedPaymentGateways['Sslcommerz']) ? 'd-none' : '' }}">
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('sslc_store_id',  __('messages.setting.sslcommerz_store_id') . ':', ['class' => 'form-label sslcommerz-store-id-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['sslc_store_id']) ?? null ? 'password' : 'text', 'sslc_store_id', $setting['sslc_store_id'] ?? null, ['class' => 'form-control  ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' =>  __('messages.setting.sslcommerz_store_id'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('sslc_store_password', __('messages.setting.sslcommerz_store_password') . ':', ['class' => 'form-label sslcommerz-password-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['sslc_store_password']) ?? null ? 'password' : 'text', 'sslc_store_password', $setting['sslc_store_password'] ?? null, ['class' => 'form-control ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.sslcommerz_store_password'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-4 mb-5">
                                {{ Form::label('sslcommerz_mode', __('messages.setting.sslcommerz_mode') . ':', ['class' => 'form-label  mb-3 required']) }}
                                {{ Form::select('sslcommerz_mode', $sslcommerzMode, $setting['sslcommerz_mode'] ?? null, ['class' => 'form-control  ', 'data-control' => 'select2', 'data-minimum-results-for-search' => 'Infinity']) }}
                            </div>
                        </div>
                    </div> --}}

                        {{-- Sslcommerz section end --}}

                        <!-- MercadoPago Card -->
                        @if (moduleExists('MercadoPago'))
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body p-3 p-md-4">
                                        <div
                                            class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center mb-2 mb-sm-0">
                                                <div class="me-2">
                                                    <svg width="30" height="30" viewBox="0 0 640 512">
                                                        <path
                                                            d="M272.2 64.6l-51.1 51.1c-15.3 4.2-29.5 11.9-41.5 22.5L153 161.9C142.8 171 129.5 176 115.8 176L96 176l0 128c20.4 .6 39.8 8.9 54.3 23.4l35.6 35.6 7 7c0 0 0 0 0 0L219.9 397c6.2 6.2 16.4 6.2 22.6 0c1.7-1.7 3-3.7 3.7-5.8c2.8-7.7 9.3-13.5 17.3-15.3s16.4 .6 22.2 6.5L296.5 393c11.6 11.6 30.4 11.6 41.9 0c5.4-5.4 8.3-12.3 8.6-19.4c.4-8.8 5.6-16.6 13.6-20.4s17.3-3 24.4 2.1c9.4 6.7 22.5 5.8 30.9-2.6c9.4-9.4 9.4-24.6 0-33.9L340.1 243l-35.8 33c-27.3 25.2-69.2 25.6-97 .9c-31.7-28.2-32.4-77.4-1.6-106.5l70.1-66.2C303.2 78.4 339.4 64 377.1 64c36.1 0 71 13.3 97.9 37.2L505.1 128l38.9 0 40 0 40 0c8.8 0 16 7.2 16 16l0 208c0 17.7-14.3 32-32 32l-32 0c-11.8 0-22.2-6.4-27.7-16l-84.9 0c-3.4 6.7-7.9 13.1-13.5 18.7c-17.1 17.1-40.8 23.8-63 20.1c-3.6 7.3-8.5 14.1-14.6 20.2c-27.3 27.3-70 30-100.4 8.1c-25.1 20.8-62.5 19.5-86-4.1L159 404l-7-7-35.6-35.6c-5.5-5.5-12.7-8.7-20.4-9.3C96 369.7 81.6 384 64 384l-32 0c-17.7 0-32-14.3-32-32L0 144c0-8.8 7.2-16 16-16l40 0 40 0 19.8 0c2 0 3.9-.7 5.3-2l26.5-23.6C175.5 77.7 211.4 64 248.7 64L259 64c4.4 0 8.9 .2 13.2 .6zM544 320l0-144-48 0c-5.9 0-11.6-2.2-15.9-6.1l-36.9-32.8c-18.2-16.2-41.7-25.1-66.1-25.1c-25.4 0-49.8 9.7-68.3 27.1l-70.1 66.2c-10.3 9.8-10.1 26.3 .5 35.7c9.3 8.3 23.4 8.1 32.5-.3l71.9-66.4c9.7-9 24.9-8.4 33.9 1.4s8.4 24.9-1.4 33.9l-.8 .8 74.4 74.4c10 10 16.5 22.3 19.4 35.1l74.8 0zM64 336a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zm528 16a16 16 0 1 0 0-32 16 16 0 1 0 0 32z"
                                                            fill="#6571FF" />
                                                    </svg>
                                                </div>
                                                <h6 class="mb-0 fw-bold">{{ __('messages.mercado_pago') }}</h6>
                                            </div>
                                            <label class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ \App\Models\Plan::MERCADO_PAGO }}"
                                                    name="payment_gateway[{{ \App\Models\Plan::MERCADO_PAGO }}]"
                                                    {{ isset($selectedPaymentGateways['Mercadopago']) ? 'checked' : '' }}
                                                    id="mercado_pago_payment">
                                            </label>
                                        </div>
                                        <div
                                            class="mercado-pago {{ !isset($selectedPaymentGateways['Mercadopago']) ? 'd-none' : '' }}">
                                            <div class="mb-3">
                                                {{ Form::label('mp_public_key', __('messages.setting.mp_public_key') . ':', ['class' => 'form-label mb-2 required fs-7']) }}
                                                <div class="position-relative">
                                                    {{ Form::input(isset($setting['mp_public_key']) ?? null ? 'password' : 'text', 'mp_public_key', $setting['mp_public_key'] ?? '', ['class' => 'form-control form-control-sm mp_public_key ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.mp_public_key'), 'data-toggle' => 'password']) }}
                                                    <span
                                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                        <i class="bi bi-eye-slash-fill fs-7"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                {{ Form::label('mp_access_token', __('messages.setting.mp_access_token') . ':', ['class' => 'form-label mb-2 required fs-7']) }}
                                                <div class="position-relative">
                                                    {{ Form::input(isset($setting['mp_access_token']) ?? null ? 'password' : 'text', 'mp_access_token', $setting['mp_access_token'] ?? '', ['class' => 'form-control form-control-sm mp_access_token ' . (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.mp_access_token'), 'data-toggle' => 'password']) }}
                                                    <span
                                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') start-0 pe-2 @else end-0 pe-2 ps-2 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                                        <i class="bi bi-eye-slash-fill fs-7"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Manual Payment -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-3 p-md-4">
                                    <div
                                        class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center mb-2 mb-sm-0">
                                            <div class="me-1">
                                                <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M26.2117 37.1748C26.2117 37.4384 26.4213 37.6537 26.682 37.6537C26.9409 37.6537 27.1523 37.4402 27.1523 37.1748C27.1523 35.9498 25.9475 34.9706 24.3341 34.8092V34.3052C24.3341 34.0415 24.1245 33.8263 23.8638 33.8263C23.6049 33.8263 23.3935 34.0397 23.3935 34.3052V34.8092C21.7819 34.9706 20.5753 35.9499 20.5753 37.1748C20.5753 38.3997 21.7801 39.379 23.3935 39.5404V42.4064C22.3367 42.2683 21.5159 41.6801 21.5159 41.0003C21.5159 40.7367 21.3063 40.5214 21.0456 40.5214C20.7867 40.5214 20.5753 40.7349 20.5753 41.0003C20.5753 42.2253 21.7801 43.2045 23.3935 43.3659V43.8699C23.3935 44.1336 23.6031 44.3488 23.8638 44.3488C24.1227 44.3488 24.3341 44.1354 24.3341 43.8699V43.3659C25.9457 43.2045 27.1523 42.2252 27.1523 41.0003C27.1523 39.7754 25.9475 38.7961 24.3341 38.6347V35.7687C25.3909 35.9068 26.2117 36.495 26.2117 37.1748ZM21.5159 37.1748C21.5159 36.495 22.3385 35.9068 23.3953 35.7705V38.5791C22.3367 38.4428 21.5159 37.8545 21.5159 37.1748ZM26.2117 41.0003C26.2117 41.6801 25.3892 42.2683 24.3323 42.4046V39.596C25.3909 39.7341 26.2117 40.3206 26.2117 41.0003ZM23.8638 31.9145C19.9782 31.9145 16.8184 35.132 16.8184 39.0885C16.8184 43.0449 19.9782 46.2625 23.8638 46.2625C27.7494 46.2625 30.9093 43.0449 30.9093 39.0885C30.9093 35.132 27.7494 31.9145 23.8638 31.9145ZM23.8638 45.3047C20.4961 45.3047 17.7572 42.5158 17.7572 39.0866C17.7572 35.6574 20.4961 32.8685 23.8638 32.8685C27.2316 32.8685 29.9705 35.6574 29.9705 39.0866C29.9705 42.5158 27.2316 45.3047 23.8638 45.3047ZM44.8627 15.7928L37.3469 8.13989C37.2589 8.05022 37.1391 8 37.0158 8H16.3479C15.0533 8 14 9.0725 14 10.3907V49.6093C14 50.9275 15.0533 52 16.3479 52H42.6504C43.945 52 44.9982 50.9275 44.9982 49.6093L45 16.1318C45 16.0044 44.9508 15.8825 44.8627 15.7928ZM37.4845 9.63393L43.3972 15.6528H38.8934C38.1166 15.6528 37.4843 15.0089 37.4843 14.2179L37.4845 9.63393ZM42.6523 51.0439H16.3481C15.5713 51.0439 14.939 50.4001 14.939 49.6091V10.3924C14.939 9.60146 15.5713 8.95762 16.3481 8.95762H36.5457V14.2179C36.5457 15.5362 37.5989 16.6087 38.8935 16.6087H44.0596V49.6091C44.0614 50.4001 43.4291 51.0439 42.6523 51.0439ZM41.2432 43.8699C41.2432 44.1336 41.0336 44.3488 40.7729 44.3488H32.3184C32.0595 44.3488 31.8481 44.1354 31.8481 43.8699C31.8481 43.6063 32.0577 43.391 32.3184 43.391H40.7729C41.0319 43.3928 41.2432 43.6063 41.2432 43.8699ZM41.2432 39.0885C41.2432 39.3521 41.0336 39.5673 40.7729 39.5673L32.3184 39.5656C32.0595 39.5656 31.8481 39.3521 31.8481 39.0867C31.8481 38.823 32.0577 38.6078 32.3184 38.6078H40.7729C41.0319 38.6096 41.2432 38.823 41.2432 39.0885ZM41.2432 34.3052C41.2432 34.5688 41.0336 34.7841 40.7729 34.7841H32.3184C32.0595 34.7841 31.8481 34.5706 31.8481 34.3052C31.8481 34.0415 32.0577 33.8263 32.3184 33.8263H40.7729C41.0319 33.8263 41.2432 34.0415 41.2432 34.3052ZM41.2432 29.5219C41.2432 29.7855 41.0336 30.0008 40.7729 30.0008H18.2274C17.9685 30.0008 17.7572 29.7874 17.7572 29.5219C17.7572 29.2583 17.9668 29.043 18.2274 29.043H40.7729C41.0319 29.0448 41.2432 29.2582 41.2432 29.5219ZM41.2432 24.7404C41.2432 25.0041 41.0336 25.2193 40.7729 25.2193L18.2274 25.2175C17.9685 25.2175 17.7572 25.0041 17.7572 24.7387C17.7572 24.475 17.9668 24.2598 18.2274 24.2598H40.7729C41.0319 24.2616 41.2432 24.475 41.2432 24.7404ZM41.2432 19.9572C41.2432 20.2208 41.0336 20.436 40.7729 20.436H18.2274C17.9685 20.436 17.7572 20.2226 17.7572 19.9572C17.7572 19.6935 17.9668 19.4783 18.2274 19.4783H40.7729C41.0319 19.4783 41.2432 19.6935 41.2432 19.9572Z"
                                                        fill="#6571FF" />
                                                </svg>
                                            </div>
                                            <h6 class="mb-0 fw-bold">{{ __('messages.setting.manually') }}</h6>
                                        </div>
                                        <label class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ \App\Models\Plan::MANUALLY }}"
                                                name="payment_gateway[{{ \App\Models\Plan::MANUALLY }}]"
                                                {{ isset($selectedPaymentGateways['Manually']) ? 'checked' : '' }}
                                                id="manually_payment">
                                        </label>
                                    </div>
                                    <div
                                        class="manually-cred{{ !isset($selectedPaymentGateways['Manually']) ? ' d-none' : '' }}">
                                        {{ Form::hidden('manual_payment_guide', $setting['manual_payment_guide'], ['id' => 'manualPaymentGuideData']) }}
                                        {{ Form::hidden('is_manual_payment_guide_on', $setting['is_manual_payment_guide_on'], ['id' => 'isManualPaymentGuideOnData']) }}
                                        <div class="mb-0">
                                            {{ Form::label('manual_payment_guide', __('messages.vcard.manual_payment_guide') . ':', ['class' => 'form-label fs-7']) }}
                                            <div id="manualPaymentGuideId" class="editor-height" style="height: 200px">
                                            </div>
                                            {{ Form::hidden('manual_payment_guide', null, ['id' => 'guideData']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary px-5', 'data-turbo' => 'false']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-payment {
            .card {
                transition: all 0.3s ease;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            }
        }
    </style>
@endsection
