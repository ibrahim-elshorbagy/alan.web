<div>
    <div class="row justify-content-between align-items-center  mb-20">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="section-heading mb-sm-0 d-flex flex-row">
                <h2 class="mb-0">{{ __('messages.whatsapp_stores_templates.reset_filters') }}</h2>

                <button type="button" wire:click="resetFilters"
                    class="d-flex align-items-center justify-content-center p-1 rounded bg-primary border-0 {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'me-3' : 'ms-3' }}"
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

        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="position-relative">
                <input type="text" wire:model.live="search"
                    placeholder="{{ __('messages.whatsapp_stores_templates.search_products') }}"
                    class="form-control ps-45 border-0" />
                <div class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                        fill="none">
                        <path
                            d="M20.6677 19.8511L16.1664 15.3497C16.1661 15.3494 16.1661 15.349 16.1664 15.3488C17.1299 14.2124 17.6898 12.7888 17.7586 11.3005C17.9523 7.26831 14.7436 4.0226 10.7095 4.17169C7.15613 4.30618 4.30643 7.15589 4.17193 10.7093C4.02288 14.7434 7.26862 17.9521 11.3008 17.7582C12.7891 17.6894 14.2126 17.1295 15.349 16.1661C15.3491 16.166 15.3493 16.1659 15.3494 16.1659C15.3496 16.1659 15.3498 16.166 15.3499 16.1661L19.8513 20.6675C20.0785 20.8912 20.4441 20.8883 20.6677 20.6611C20.889 20.4364 20.889 20.0758 20.6677 19.8511ZM5.4683 12.2762C5.02515 10.2981 5.60401 8.34583 6.97507 6.9748C8.34614 5.60376 10.2983 5.02488 12.2765 5.46806C14.1481 5.88748 16.0458 7.78498 16.4652 9.65637C16.9087 11.6347 16.3297 13.5872 14.9586 14.9584C13.5875 16.3295 11.6349 16.9084 9.65651 16.4649C7.78512 16.0454 5.88772 14.1477 5.4683 12.2762Z"
                            fill="#999999" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-40">
        <div class="col-xl-3 col-lg-4 mb-40">
            <div class="items-filter-wrapper mb-3">
                <div class="row mx-0">
                    <div class="col-4 ps-0 px-1">
                        <input type="number" class="form-control" min="0"
                            placeholder="{{ __('messages.whatsapp_stores_templates.min') }}" wire:model.defer="minPrice"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                    </div>
                    <div class="col-4 px-1">
                        <input type="number" class="form-control" min="1"
                            placeholder="{{ __('messages.whatsapp_stores_templates.max') }}" wire:model.defer="maxPrice"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                    </div>
                    <div class="col-4 pe-0 px-1">
                        <button wire:click="applyPriceFilter" type="submit" class="apply-btn btn btn-primary w-100">
                            {{ __('messages.whatsapp_stores_templates.apply') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="items-filter-wrapper p-0 mb-3" wire:ignore>
                <div class="position-relative">
                    <div class="custom-select-box text-black d-flex align-items-center position-relative">
                        <div class="custom-arrow-select position-absolute d-flex align-items-center {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'rtl-arrow' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.41098 6.91098C4.25476 7.06725 4.16699 7.27918 4.16699 7.50015C4.16699 7.72112 4.25476 7.93304 4.41098 8.08931L9.41098 13.0893C9.56725 13.2455 9.77918 13.3333 10.0001 13.3333C10.2211 13.3333 10.433 13.2455 10.5893 13.0893L15.5893 8.08931C15.7411 7.93215 15.8251 7.72164 15.8232 7.50315C15.8213 7.28465 15.7337 7.07564 15.5792 6.92113C15.4247 6.76663 15.2156 6.67898 14.9971 6.67709C14.7787 6.67519 14.5681 6.75918 14.411 6.91098L10.0001 11.3218L5.58931 6.91098C5.43304 6.75476 5.22112 6.66699 5.00015 6.66699C4.77918 6.66699 4.56725 6.75476 4.41098 6.91098Z"
                                    fill="#27262E" />
                            </svg>
                        </div>
                        <span
                            class="select-text fs-16 fw-5 lh-1">{{ __('messages.whatsapp_stores_templates.search_price_range') }}</span>
                    </div>
                    <div class="custom-select-options">
                        <div class="custom-select-option fs-14 fw-6 text-black drop-item-select"
                            wire:click.prevent="setPriceSortOrder('1')" data-value="1">
                            {{ __('messages.whatsapp_stores_templates.low_to_high') }}</div>
                        <div class="custom-select-option fs-14 fw-6 text-black drop-item-select"
                            wire:click.prevent="setPriceSortOrder('2')" data-value="2">
                            {{ __('messages.whatsapp_stores_templates.high_to_low') }}</div>

                    </div>
                </div>
            </div>
            <div class="items-filter-wrapper mb-3">
                <div class="p-2">
                    <div class="heading-text mb-3">
                        <h3 class="">{{ __('messages.whatsapp_stores_templates.date_posted') }}</h3>
                    </div>
                    <div>
                        <div class="form-check d-flex align-items-center gap-3 mb-2 ps-0">
                            <input class="form-check-input m-0 p-0" type="radio" id="inlineCheckbox1"
                                name="flexcheckboxDefault" wire:model.live="dateFilter" value="3_days">
                            <label class="form-check-label fs-16 fw-5 lh-1" for="inlineCheckbox1">3
                                {{ __('messages.whatsapp_stores_templates.days_ago') }}</label>
                        </div>
                        <div class="form-check d-flex align-items-center gap-3 mb-2 ps-0">
                            <input class="form-check-input m-0 p-0" name="flexcheckboxDefault" type="radio"
                                wire:model.live="dateFilter" value="1_week" id="inlineCheckbox2" value="option2">
                            <label class="form-check-label fs-16 fw-5 lh-1" for="inlineCheckbox2">1
                                {{ __('messages.whatsapp_stores_templates.week_ago') }}</label>
                        </div>
                        <div class="form-check d-flex align-items-center gap-3 mb-2 ps-0">
                            <input class="form-check-input m-0 p-0" name="flexcheckboxDefault" type="radio"
                                wire:model.live="dateFilter" value="1_month" id="inlineCheckbox3" value="option3">
                            <label class="form-check-label fs-16 fw-5 lh-1" for="inlineCheckbox3">1
                                {{ __('messages.whatsapp_stores_templates.month_ago') }}</label>
                        </div>
                        <div class="form-check d-flex align-items-center gap-3 mb-2 ps-0">
                            <input class="form-check-input m-0 p-0" name="flexcheckboxDefault"
                                wire:model.live="dateFilter" value="6_months" type="radio" id="inlineCheckbox4"
                                value="option4">
                            <label class="form-check-label fs-16 fw-5 lh-1" for="inlineCheckbox4">6
                                {{ __('messages.whatsapp_stores_templates.months_ago') }}</label>
                        </div>
                        <div class="form-check d-flex align-items-center gap-3 mb-0 ps-0">
                            <input class="form-check-input m-0 p-0" name="flexcheckboxDefault"
                                wire:model.live="dateFilter" value="1_year" type="radio" id="inlineCheckbox4"
                                value="option4">
                            <label class="form-check-label fs-16 fw-5 lh-1" for="inlineCheckbox4"> 1
                                {{ __('messages.whatsapp_stores_templates.year_ago') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="items-filter-wrapper">
                <div class="p-2">
                    <div class="heading-text mb-3">
                        <h3 class="">{{ __('messages.whatsapp_stores_templates.all_categories') }}</h3>
                    </div>
                    <div>
                        @foreach ($categories as $category)
                            <div class="form-check d-flex align-items-center gap-3 mb-2 ps-0">
                                <input class="form-check-input m-0 p-0" type="checkbox"
                                    wire:model.live="categoryFilter" value="{{ $category->id }}"
                                    id="flexcheckboxCategory-{{ $category->id }}">
                                <label class="form-check-label fs-16 fw-5 lh-1"
                                    for="flexcheckboxCategory-{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8">
            <div class="row item-cards mb-40">
                @foreach ($products as $product)
                    <div class="col-xl-3 col-sm-6 mb-20">
                <div class="d-flex flex-column h-100 item-card justify-content-between">
                    <a href="{{ route('whatsapp.store.product.details', [$urlAlias, $product->id]) }}"
                        class=" d-flex flex-column text-black">
                        <div class="item-img bg-yellow">
                            <img src="{{ $product->images_url[0] ?? '' }}" alt="item"
                                class="w-100 h-100 object-fit-cover product-image" loading="lazy" />
                        </div>
                       <div class="flex-grow-1">
                            <div class="item-details text-center">
                             <h5 class="fs-22 fw-6 mb-0 product-name">{{ $product->name }}</h5>
                             <p class="fs-16 fw-5 mb-1 text-gray-200 product-category">
                                 {{ $product->category->name }}</p>
                             <p class="fs-18 fw-6 mb-2">
                                <span class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                                 @if ($product->net_price)
                                     <del class="fs-20 fw-5 text-gray-200">{{ currencyFormat($product->net_price, 2, $product->currency->currency_code) }}</del>
                                 @endif
                             </p>
                            </div>
                       </div>
                    </a>
                       <button data-id="{{ $product->id }}"
                        class="@if($product->available_stock == 0) disabled @endif mb-2 btn btn-primary d-flex justify-content-center align-items-center mx-auto gap-2 addToCartBtn add-to-cart-w-140px">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 30 30" fill="none">
                                <path
                                    d="M4.06864 11.7857L6.75321 23.5389C6.8827 24.1133 7.20391 24.6265 7.66397 24.994C8.12403 25.3615 8.69552 25.5614 9.28435 25.5609H15.5766C15.804 25.5609 16.022 25.4706 16.1827 25.3098C16.3435 25.1491 16.4338 24.931 16.4338 24.7037C16.4338 24.4764 16.3435 24.2584 16.1827 24.0976C16.022 23.9369 15.804 23.8466 15.5766 23.8466H9.28435C8.87292 23.8466 8.51807 23.5603 8.42378 23.154L5.7375 11.3974C5.70906 11.2683 5.70992 11.1345 5.74001 11.0058C5.7701 10.8771 5.82866 10.7567 5.91138 10.6536C5.99409 10.5505 6.09887 10.4672 6.218 10.41C6.33713 10.3527 6.46759 10.3228 6.59978 10.3226H8.78378V12.3309C8.78378 12.5582 8.87409 12.7762 9.03483 12.9369C9.19558 13.0977 9.4136 13.188 9.64092 13.188C9.86825 13.188 10.0863 13.0977 10.247 12.9369C10.4078 12.7762 10.4981 12.5582 10.4981 12.3309V10.3217H20.1101V12.3309C20.1101 12.5582 20.2004 12.7762 20.3611 12.9369C20.5219 13.0977 20.7399 13.188 20.9672 13.188C21.1945 13.188 21.4126 13.0977 21.5733 12.9369C21.734 12.7762 21.8244 12.5582 21.8244 12.3309V10.3217H24.0084C24.1412 10.3219 24.2723 10.3521 24.3919 10.4099C24.5115 10.4678 24.6166 10.5518 24.6992 10.6558C24.7819 10.7598 24.8401 10.8811 24.8695 11.0107C24.8989 11.1403 24.8987 11.2748 24.8689 11.4043L22.9146 19.956C22.8896 20.0657 22.8864 20.1794 22.9053 20.2903C22.9241 20.4013 22.9647 20.5075 23.0246 20.6028C23.0845 20.6981 23.1625 20.7807 23.2543 20.8458C23.3462 20.911 23.4499 20.9574 23.5596 20.9824C23.6694 21.0075 23.783 21.0107 23.894 20.9918C24.0049 20.9729 24.1111 20.9324 24.2064 20.8725C24.3017 20.8126 24.3843 20.7345 24.4495 20.6427C24.5146 20.5509 24.561 20.4472 24.5861 20.3374L26.5378 11.7917C26.6282 11.4129 26.6312 11.0184 26.5465 10.6382C26.4619 10.258 26.2918 9.90213 26.0492 9.59743C25.8066 9.28838 25.4969 9.03862 25.1434 8.86708C24.79 8.69555 24.4021 8.60676 24.0092 8.60743H21.7532C21.3075 5.44457 18.5886 3 15.3041 3C12.0195 3 9.3015 5.44371 8.85492 8.60743H6.59978C5.80007 8.60743 5.05692 8.96829 4.55978 9.59743C4.31745 9.90112 4.14732 10.2559 4.06223 10.635C3.97715 11.0141 3.97934 11.4076 4.06864 11.7857ZM15.3041 4.71429C16.4197 4.71598 17.5 5.10517 18.3604 5.8153C19.2208 6.52543 19.8077 7.5124 20.0209 8.60743H10.5872C10.8004 7.5124 11.3874 6.52543 12.2477 5.8153C13.1081 5.10517 14.1885 4.71598 15.3041 4.71429Z"
                                    fill="currentColor" />
                                <path
                                    d="M20.9296 20.7959C20.7023 20.7959 20.4843 20.8862 20.3235 21.047C20.1628 21.2077 20.0725 21.4257 20.0725 21.653V23.0408H18.6848C18.4575 23.0408 18.2394 23.1311 18.0787 23.2918C17.9179 23.4526 17.8276 23.6706 17.8276 23.8979C17.8276 24.1252 17.9179 24.3432 18.0787 24.504C18.2394 24.6647 18.4575 24.755 18.6848 24.755H20.0734V26.1428C20.0734 26.3701 20.1637 26.5881 20.3244 26.7488C20.4851 26.9096 20.7032 26.9999 20.9305 26.9999C21.1578 26.9999 21.3758 26.9096 21.5366 26.7488C21.6973 26.5881 21.7876 26.3701 21.7876 26.1428V24.7542H23.1754C23.4027 24.7542 23.6207 24.6639 23.7814 24.5031C23.9422 24.3424 24.0325 24.1244 24.0325 23.897C24.0325 23.6697 23.9422 23.4517 23.7814 23.291C23.6207 23.1302 23.4027 23.0399 23.1754 23.0399H21.7868V21.653C21.7868 21.4257 21.6965 21.2077 21.5357 21.047C21.375 20.8862 21.157 20.7959 20.9296 20.7959Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        {{ __('messages.whatsapp_stores_templates.add_to_cart') }}
                    </button>
                </div>

                    </div>
                @endforeach
                <div class="mt-4 d-flex justify-content-center custom-pagination">
                    {{ $products->links() }}
                </div>
                @if ($products->count() == 0)
                    <div class="no-items-found d-flex justify-content-center align-items-center">
                        <h2 class="text-center">{{ __('messages.whatsapp_stores.no_items_found') }}</h2>
                    </div>
                @endif
            </div>
            <div>

            </div>
        </div>
    </div>
</div>
