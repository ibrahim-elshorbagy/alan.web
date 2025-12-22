<div>
    <div class="px-50">
        <div class="filter-section mb-20">
            <div class="d-flex justify-content-between gap-2 align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <p class="fs-26 fw-5 text-black mb-0">{{ __('messages.whatsapp_stores_templates.filter') }}</p>

                    <!-- Reset Icon Button -->
                    <button type="button"  wire:click="resetFilters"
                        class="d-flex align-items-center justify-content-center p-1 rounded bg-black border-0"
                        style="width: 32px; height: 32px;">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                            width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                            <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                <path
                                    d="M 7.288 48.34 c 0.061 0.04 0.129 0.068 0.193 0.105 c 0.18 0.105 0.363 0.201 0.559 0.277 c 0.093 0.036 0.19 0.06 0.286 0.089 c 0.175 0.053 0.351 0.098 0.535 0.127 c 0.049 0.008 0.094 0.028 0.144 0.034 C 9.164 48.99 9.322 49 9.481 49 c 0 0 0 0 0.001 0 c 0 0 0 0 0 0 c 0 0 0 0 0 0 c 0.267 0 0.531 -0.028 0.79 -0.08 c 0.154 -0.031 0.297 -0.086 0.443 -0.134 c 0.101 -0.033 0.206 -0.054 0.304 -0.094 c 0.162 -0.067 0.31 -0.158 0.46 -0.245 c 0.075 -0.043 0.156 -0.075 0.228 -0.124 c 0.217 -0.146 0.42 -0.311 0.604 -0.495 c 0 0 0 0 0 0 l 7.492 -7.492 c 1.562 -1.562 1.562 -4.095 0 -5.657 c -1.149 -1.149 -2.822 -1.445 -4.249 -0.903 c 4.535 -11.868 16.033 -20.322 29.475 -20.322 c 12.266 0 23.516 7.2 28.658 18.342 c 0.926 2.004 3.3 2.881 5.309 1.956 c 2.005 -0.926 2.881 -3.302 1.955 -5.308 C 74.503 14.478 60.403 5.455 45.027 5.455 c -17.837 0 -32.947 11.873 -37.859 28.129 c -1.224 -1.611 -3.48 -2.084 -5.247 -1.008 c -1.887 1.148 -2.486 3.609 -1.338 5.496 l 5.481 9.007 c 0.014 0.023 0.035 0.041 0.049 0.063 c 0.125 0.195 0.268 0.375 0.424 0.545 c 0.036 0.039 0.064 0.085 0.101 0.122 C 6.835 48.009 7.053 48.186 7.288 48.34 z"
                                    style="fill: #ffffff;" transform=" matrix(1 0 0 1 0 0)" stroke-linecap="round" />
                                <path
                                    d="M 89.416 51.929 l -5.48 -9.008 c -0.014 -0.023 -0.035 -0.04 -0.049 -0.063 c -0.125 -0.195 -0.268 -0.375 -0.424 -0.546 c -0.035 -0.039 -0.063 -0.084 -0.1 -0.121 c -0.197 -0.199 -0.415 -0.376 -0.65 -0.531 c -0.061 -0.04 -0.129 -0.067 -0.192 -0.104 c -0.18 -0.105 -0.364 -0.201 -0.56 -0.277 c -0.093 -0.036 -0.19 -0.06 -0.287 -0.089 c -0.174 -0.053 -0.35 -0.098 -0.534 -0.127 c -0.049 -0.008 -0.095 -0.028 -0.144 -0.034 c -0.07 -0.008 -0.138 0.003 -0.208 -0.001 C 80.697 41.021 80.611 41 80.519 41 c -0.082 0 -0.159 0.019 -0.239 0.024 c -0.121 0.007 -0.24 0.018 -0.36 0.036 c -0.172 0.026 -0.338 0.065 -0.503 0.113 c -0.105 0.03 -0.209 0.058 -0.312 0.097 c -0.178 0.067 -0.344 0.152 -0.509 0.243 c -0.082 0.045 -0.166 0.082 -0.245 0.133 c -0.237 0.153 -0.46 0.326 -0.659 0.524 c 0 0 -0.001 0.001 -0.001 0.001 l 0 0 l 0 0 l -7.492 7.492 c -1.562 1.562 -1.562 4.095 0 5.656 c 1.148 1.15 2.822 1.446 4.249 0.904 c -4.535 11.868 -16.033 20.321 -29.475 20.321 c -12.707 0 -24.117 -7.563 -29.068 -19.268 c -0.861 -2.034 -3.209 -2.988 -5.242 -2.125 c -2.035 0.86 -2.986 3.207 -2.126 5.242 c 6.206 14.671 20.508 24.151 36.436 24.151 c 17.831 0 32.937 -11.864 37.854 -28.111 c 0.774 1.015 1.96 1.574 3.176 1.574 c 0.708 0 1.426 -0.188 2.075 -0.584 C 89.966 56.276 90.565 53.816 89.416 51.929 z"
                                    style="fill: #ffffff;" transform=" matrix(1 0 0 1 0 0)" stroke-linecap="round" />
                            </g>
                        </svg>
                    </button>

                </div>
                <div class="position-relative">
                    <div class="search-icon position-absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M15.0001 8.33366C15.0001 10.1018 14.2977 11.7975 13.0475 13.0477C11.7972 14.2979 10.1015 15.0003 8.33341 15.0003C6.5653 15.0003 4.86961 14.2979 3.61937 13.0477C2.36913 11.7975 1.66675 10.1018 1.66675 8.33366C1.66675 6.56555 2.36913 4.86986 3.61937 3.61961C4.86961 2.36937 6.5653 1.66699 8.33341 1.66699C10.1015 1.66699 11.7972 2.36937 13.0475 3.61961C14.2977 4.86986 15.0001 6.56555 15.0001 8.33366ZM13.7501 8.33366C13.7501 9.77025 13.1794 11.148 12.1636 12.1638C11.1478 13.1796 9.77 13.7503 8.33341 13.7503C6.89683 13.7503 5.51907 13.1796 4.50325 12.1638C3.48743 11.148 2.91675 9.77025 2.91675 8.33366C2.91675 6.89707 3.48743 5.51932 4.50325 4.5035C5.51907 3.48767 6.89683 2.91699 8.33341 2.91699C9.77 2.91699 11.1478 3.48767 12.1636 4.5035C13.1794 5.51932 13.7501 6.89707 13.7501 8.33366Z"
                                fill="#999999" />
                            <path
                                d="M17.1083 16.225L14.1916 13.3083C14.1344 13.2469 14.0654 13.1976 13.9887 13.1635C13.9121 13.1293 13.8293 13.111 13.7454 13.1095C13.6615 13.108 13.5781 13.1234 13.5003 13.1549C13.4225 13.1863 13.3518 13.2331 13.2924 13.2924C13.2331 13.3518 13.1863 13.4225 13.1549 13.5003C13.1234 13.5781 13.108 13.6615 13.1095 13.7454C13.111 13.8293 13.1293 13.9121 13.1635 13.9887C13.1976 14.0654 13.2469 14.1344 13.3083 14.1916L16.225 17.1083C16.2822 17.1697 16.3512 17.219 16.4278 17.2531C16.5045 17.2873 16.5873 17.3056 16.6712 17.3071C16.7551 17.3086 16.8385 17.2932 16.9163 17.2617C16.9941 17.2303 17.0648 17.1835 17.1242 17.1242C17.1835 17.0648 17.2303 16.9941 17.2617 16.9163C17.2932 16.8385 17.3086 16.7551 17.3071 16.6712C17.3056 16.5873 17.2873 16.5045 17.2531 16.4278C17.219 16.3512 17.1697 16.2822 17.1083 16.225Z"
                                fill="#999999" />
                        </svg>
                    </div>
                    <input type="search" wire:model.live="search" placeholder="{{ __('messages.whatsapp_stores_templates.search_products') }}"
                        class="form-control serach-input fs-14 fw-5 text-gray-200 w-100" />
                </div>
            </div>
        </div>
    </div>


    <div class="px-50 mb-3">
        <div class="select-all-section">
            <div class="row justify-content-around row-gap-3">
                <div class="col-xl-3 col-sm-6" wire:ignore>
                    <div class="dropdown custom-dropdown bg-white">
                        <button
                            class="btn dropdown-toggle fs-18 fw-5 text-black p-0 lh-1 d-flex align-items-center justify-content-between w-100"
                            type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('messages.whatsapp_stores_templates.date_posted') }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.41098 6.91098C4.25476 7.06725 4.16699 7.27918 4.16699 7.50015C4.16699 7.72112 4.25476 7.93304 4.41098 8.08931L9.41098 13.0893C9.56725 13.2455 9.77918 13.3333 10.0001 13.3333C10.2211 13.3333 10.433 13.2455 10.5893 13.0893L15.5893 8.08931C15.7411 7.93215 15.8251 7.72164 15.8232 7.50315C15.8213 7.28465 15.7337 7.07564 15.5792 6.92113C15.4247 6.76663 15.2156 6.67898 14.9971 6.67709C14.7787 6.67519 14.5681 6.75918 14.411 6.91098L10.0001 11.3218L5.58931 6.91098C5.43304 6.75476 5.22112 6.66699 5.00015 6.66699C4.77918 6.66699 4.56725 6.75476 4.41098 6.91098Z"
                                    fill="#27262E" />
                            </svg>
                        </button>
                        <ul class="dropdown-menu border-0 h-100" aria-labelledby="dropdownMenuButton">
                            <div class="form-check d-flex align-items-center gap-3 mb-10">
                                <input class="form-check-input m-0 p-0" type="radio" name="inlineRadioOptions"
                                    id="inlineCheckbox1" wire:model.live="dateFilter" value="3_days">
                                <label class="form-check-label fs-18 fw-5 lh-1" for="inlineCheckbox1">3
                                    {{ __('messages.whatsapp_stores_templates.days_ago') }}</label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-3 mb-10">
                                <input class="form-check-input m-0 p-0" type="radio" name="inlineRadioOptions"
                                    wire:model.live="dateFilter" value="1_week" id="inlineCheckbox2" value="option2">
                                <label class="form-check-label fs-18 fw-5 lh-1" for="inlineCheckbox2">1
                                    {{ __('messages.whatsapp_stores_templates.week_ago') }}</label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-3 mb-10">
                                <input class="form-check-input m-0 p-0" type="radio" name="inlineRadioOptions"
                                    id="inlineCheckbox3" wire:model.live="dateFilter" value="1_month" value="option3">
                                <label class="form-check-label fs-18 fw-5 lh-1" for="inlineCheckbox3">1
                                    {{ __('messages.whatsapp_stores_templates.month_ago') }}</label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-3 mb-10">
                                <input class="form-check-input m-0 p-0" type="radio" name="inlineRadioOptions"
                                    id="inlineCheckbox4" wire:model.live="dateFilter" value="6_months" value="option4">
                                <label class="form-check-label fs-18 fw-5 lh-1" for="inlineCheckbox4">6
                                    {{ __('messages.whatsapp_stores_templates.months_ago') }}</label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-3 mb-10">
                                <input class="form-check-input m-0 p-0" type="radio" name="inlineRadioOptions"
                                    id="inlineCheckbox5" wire:model.live="dateFilter" value="1_year"
                                    value="option4">
                                <label class="form-check-label fs-18 fw-5 lh-1" for="inlineCheckbox5">1
                                    {{ __('messages.whatsapp_stores_templates.year_ago') }}</label>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6" wire:ignore>
                    <div class="dropdown custom-dropdown bg-white">
                        <button
                            class="btn dropdown-toggle fs-18 fw-5 text-black p-0 lh-1 d-flex align-items-center justify-content-between w-100"
                            type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('messages.whatsapp_stores_templates.all_categories') }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 20 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.41098 6.91098C4.25476 7.06725 4.16699 7.27918 4.16699 7.50015C4.16699 7.72112 4.25476 7.93304 4.41098 8.08931L9.41098 13.0893C9.56725 13.2455 9.77918 13.3333 10.0001 13.3333C10.2211 13.3333 10.433 13.2455 10.5893 13.0893L15.5893 8.08931C15.7411 7.93215 15.8251 7.72164 15.8232 7.50315C15.8213 7.28465 15.7337 7.07564 15.5792 6.92113C15.4247 6.76663 15.2156 6.67898 14.9971 6.67709C14.7787 6.67519 14.5681 6.75918 14.411 6.91098L10.0001 11.3218L5.58931 6.91098C5.43304 6.75476 5.22112 6.66699 5.00015 6.66699C4.77918 6.66699 4.56725 6.75476 4.41098 6.91098Z"
                                    fill="#27262E" />
                            </svg>
                        </button>
                        <ul class="dropdown-menu border-0 h-100" aria-labelledby="dropdownMenuButton">
                            @foreach ($categories as $category)
                                <div class="form-check d-flex align-items-center gap-3 mb-10">
                                    <input class="form-check-input m-0 p-0" type="checkbox"
                                        id="category-{{ $category->id }}" wire:model.live="categoryFilter"
                                        value="{{ $category->id }}">
                                    <label class="form-check-label fs-18 fw-5 lh-1"
                                        for="category-{{ $category->id }}"> {{ $category->name }}</label>
                                </div>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6" wire:ignore>
                    <div class="custom-select-container position-relative">
                        <div class="custom-select">
                            <div
                                class="custom-select-box fs-20 lh-1 fw-5 text-black d-flex align-items-center position-relative">
                                <!-- SVG Icon Inside the Box -->
                                <div class="custom-arrow-select position-absolute d-flex align-items-center {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'rtl-arrow' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.41098 6.91098C4.25476 7.06725 4.16699 7.27918 4.16699 7.50015C4.16699 7.72112 4.25476 7.93304 4.41098 8.08931L9.41098 13.0893C9.56725 13.2455 9.77918 13.3333 10.0001 13.3333C10.2211 13.3333 10.433 13.2455 10.5893 13.0893L15.5893 8.08931C15.7411 7.93215 15.8251 7.72164 15.8232 7.50315C15.8213 7.28465 15.7337 7.07564 15.5792 6.92113C15.4247 6.76663 15.2156 6.67898 14.9971 6.67709C14.7787 6.67519 14.5681 6.75918 14.411 6.91098L10.0001 11.3218L5.58931 6.91098C5.43304 6.75476 5.22112 6.66699 5.00015 6.66699C4.77918 6.66699 4.56725 6.75476 4.41098 6.91098Z"
                                            fill="#27262E" />
                                    </svg>
                                </div>
                                <!-- Text for Select Price Range -->
                                <span
                                    class="select-text fs-18 fw-5 lh-1">{{ __('messages.whatsapp_stores_templates.search_price_range') }}</span>
                            </div>
                            <div class="custom-select-options">
                                <div class="custom-select-option fs-14 fw-6 text-black"
                                    wire:click.prevent="setPriceSortOrder('1')" data-value="1">
                                    {{ __('messages.whatsapp_stores_templates.low_to_high') }}</div>
                                <div class="custom-select-option fs-14 fw-6 text-black"
                                    wire:click.prevent="setPriceSortOrder('2')" data-value="2">
                                    {{ __('messages.whatsapp_stores_templates.high_to_low') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--all-items -->
    <div class="all-items-section px-50">
        <div class="section-heading">
            <h2 class="position-relative mb-0">{{ __('messages.whatsapp_stores_templates.all_items') }}</h2>
        </div>
        <div class="row row-gap-4 mb-30">
            @foreach ($products as $product)
                <div class="col-lg-3 col-sm-6">
                    <div class="h-100 d-flex justify-content-between flex-column product-card bg-white">
                        <a href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}"
                            class="d-flex text-black flex-column">
                            <div class="h-100 d-flex flex-column">
                                <div class="product-all-img h-100 mb-10">
                                    <img src="{{ $product->images_url[0] ?? '' }}" alt="images"
                                        class="h-100 w-100 object-fit-cover product-image" />
                                </div>
                                    <div class="mb-2 mb-lg-4 h-100 product-details">
                                        <p class="fs-16 fw-5 text-black mb-10 product-name">{{ $product->name }}</p>
                                        <p class="fs-14 text-gray-200 fw-5 mb-0 product-category">
                                            {{ $product->category->name }}</p>
                                    </div>
                            </div>
                        </a>
                        <div
                        class="d-flex justify-content-between mb-10 align-items-center flex-nowrap gap-2 product-details">
                        <a class="fs-20 fw-7 lh-sm mb-0 " href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}">
                            <span class="currency_icon selling_price text-black">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                            @if ($product->net_price)
                                <del class="fs-14 fw-6 text-gray-200 text-nowrap">{{ currencyFormat($product->net_price, 2, $product->currency->currency_code) }}</del>
                            @endif
                        </a>
                        <button
                            class="@if($product->available_stock == 0) disabled @endif btn btn-primary d-flex gap-2 align-items-center fs-12 fw-6 ms-auto addToCartBtn addToCartButton add-to-cart-min-w-127px"
                            data-id="{{ $product->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                viewBox="0 0 21 21" fill="none">
                                <path
                                    d="M7.40454 6.2622C7.40454 4.55269 8.79024 3.16699 10.4997 3.16699C12.2093 3.16699 13.595 4.55269 13.595 6.2622C13.595 6.38849 13.5448 6.50961 13.4555 6.59891C13.3662 6.68822 13.2451 6.73838 13.1188 6.73838C12.9925 6.73838 12.8714 6.68822 12.7821 6.59891C12.6928 6.50961 12.6426 6.38849 12.6426 6.2622C12.6426 5.69388 12.4168 5.14885 12.015 4.74699C11.6131 4.34513 11.0681 4.11936 10.4997 4.11936C9.93143 4.11936 9.38639 4.34513 8.98453 4.74699C8.58268 5.14885 8.35691 5.69388 8.35691 6.2622C8.35691 6.38849 8.30674 6.50961 8.21744 6.59891C8.12814 6.68822 8.00702 6.73838 7.88073 6.73838C7.75443 6.73838 7.63331 6.68822 7.54401 6.59891C7.45471 6.50961 7.40454 6.38849 7.40454 6.2622ZM10.9759 10.5479C10.9759 10.4216 10.9258 10.3005 10.8365 10.2112C10.7472 10.1219 10.626 10.0717 10.4997 10.0717C10.3735 10.0717 10.2523 10.1219 10.163 10.2112C10.0737 10.3005 10.0236 10.4216 10.0236 10.5479V11.9764H8.59501C8.46871 11.9764 8.34759 12.0266 8.25829 12.1159C8.16899 12.2052 8.11882 12.3263 8.11882 12.4526C8.11882 12.5789 8.16899 12.7 8.25829 12.7893C8.34759 12.8786 8.46871 12.9288 8.59501 12.9288H10.0236V14.3574C10.0236 14.4836 10.0737 14.6048 10.163 14.6941C10.2523 14.7834 10.3735 14.8335 10.4997 14.8335C10.626 14.8335 10.7472 14.7834 10.8365 14.6941C10.9258 14.6048 10.9759 14.4836 10.9759 14.3574V12.9288H12.4045C12.5308 12.9288 12.6519 12.8786 12.7412 12.7893C12.8305 12.7 12.8807 12.5789 12.8807 12.4526C12.8807 12.3263 12.8305 12.2052 12.7412 12.1159C12.6519 12.0266 12.5308 11.9764 12.4045 11.9764H10.9759V10.5479Z"
                                    fill="currentColor" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.83512 8.94159C4.90606 8.49338 5.13463 8.08519 5.4797 7.79049C5.82477 7.49578 6.26369 7.33391 6.71749 7.33398H14.2819C14.7358 7.33385 15.1747 7.4957 15.5199 7.79041C15.865 8.08512 16.0936 8.49333 16.1645 8.94159L17.1429 15.132C17.3255 16.2887 16.4307 17.3339 15.2603 17.3339H5.7394C4.56894 17.3339 3.67418 16.2887 3.85704 15.132L4.83512 8.94159ZM6.71749 8.28636C6.49053 8.28628 6.27099 8.36719 6.09837 8.51454C5.92575 8.66189 5.81138 8.866 5.77583 9.09016L4.7975 15.2806C4.77606 15.4166 4.78437 15.5557 4.82185 15.6882C4.85934 15.8207 4.92512 15.9435 5.01465 16.0482C5.10417 16.1528 5.21533 16.2368 5.34045 16.2944C5.46557 16.3519 5.60168 16.3816 5.7394 16.3815H15.2603C15.398 16.3816 15.5341 16.3518 15.6592 16.2943C15.7843 16.2367 15.8954 16.1527 15.9849 16.0481C16.0744 15.9435 16.1402 15.8207 16.1777 15.6882C16.2152 15.5557 16.2236 15.4166 16.2022 15.2806L15.2238 9.09016C15.1883 8.86596 15.0739 8.66182 14.9012 8.51446C14.7285 8.36711 14.5089 8.28622 14.2819 8.28636H6.71749Z"
                                    fill="currentColor" />
                            </svg>
                            {{ __('messages.whatsapp_stores_templates.add_to_cart') }}
                        </button>
                    </div>
                    </div>
                </div>
            @endforeach
            @if ($products->count() == 0)
            <div style="min-height: 300px;" class="d-flex justify-content-center align-items-center">
                <h2 class="text-center">{{ __('messages.whatsapp_stores.no_product_found') }}</h2>
            </div>
        @endif

        </div>
        <div class="mt-4 d-flex justify-content-center page-number custom-pagination custom-pagination">
            {{ $products->links() }}
        </div>

    </div>

</div>
