<div class="row">
    <div class="col-xl-3 col-lg-4 mb-40">
        <div class="items-tabs bg-white">
            <div class="tabs-heading mb-20">
                <p class="fs-20 fw-6 text-black mb-0 lh-sm">{{ __('messages.common.filter') }}</p>
            </div>
            <div class="row mx-0 mb-30">
                <div class="col-4 ps-0 px-1">
                    <input type="number" min="0" class="form-control" wire:model.defer="minPrice"
                        placeholder="{{ __('messages.whatsapp_stores_templates.min') }}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                </div>
                <div class="col-4 px-1">
                    <input type="number" min="1" class="form-control" wire:model.defer="maxPrice"
                        placeholder="{{ __('messages.whatsapp_stores_templates.max') }}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                </div>
                <div class="col-4 pe-0 px-1">
                    <button wire:click="applyPriceFilter" class="apply-btn btn btn-primary w-100 h-100">
                        {{ __('messages.whatsapp_stores_templates.apply') }}
                    </button>
                </div>
            </div>
            <div class="mb-20 date-posted">
                <div class="heading-text mb-20">
                    <h3 class="mb-0 fs-20 fw-6">{{ __('messages.whatsapp_stores_templates.date_posted') }}</h3>
                </div>
                <div>
                    <div class="form-check mb-2">
                        <input class="form-check-input {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'float-end' : '' }}" type="radio" name="flexcheckboxDefault"
                            id="flexcheckboxDefault1" wire:model.live="dateFilter" value="3_days" />
                        <label class="form-check-label fs-20 fw-5 text-black lh-sm {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'me-4' : '' }}" for="flexcheckboxDefault1">
                            3 {{ __('messages.whatsapp_stores_templates.days_ago') }}
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'float-end' : '' }}" type="radio" wire:model.live="dateFilter" value="1_week"
                            name="flexcheckboxDefault" id="flexcheckboxDefault2" />
                        <label class="form-check-label fs-20 fw-5 text-black lh-sm {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'me-4' : '' }}" for="flexcheckboxDefault2">
                            1 {{ __('messages.whatsapp_stores_templates.week_ago') }}
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'float-end' : '' }}" type="radio" wire:model.live="dateFilter" value="1_month"
                            name="flexcheckboxDefault" id="flexcheckboxDefault3" />
                        <label class="form-check-label fs-20 fw-5 text-black lh-sm {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'me-4' : '' }}" for="flexcheckboxDefault3">
                            1 {{ __('messages.whatsapp_stores_templates.month_ago') }}
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'float-end' : '' }}" type="radio" wire:model.live="dateFilter" value="6_months"
                            name="flexcheckboxDefault" id="flexcheckboxDefault4" />
                        <label class="form-check-label fs-20 fw-5 text-black lh-sm {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'me-4' : '' }}" for="flexcheckboxDefault4">
                            6 {{ __('messages.whatsapp_stores_templates.months_ago') }}
                        </label>
                    </div>
                    <div class="form-check mb-0">
                        <input class="form-check-input {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'float-end' : '' }}" type="radio" wire:model.live="dateFilter" value="1_year"
                            name="flexcheckboxDefault" id="flexcheckboxDefault5" />
                        <label class="form-check-label fs-20 fw-5 text-black lh-sm {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'me-4' : '' }}" for="flexcheckboxDefault5">
                            1 {{ __('messages.whatsapp_stores_templates.year_ago') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="date-posted">
                <div class="heading-text mb-20">
                    <h3 class="mb-0 fs-20 fw-6">{{ __('messages.whatsapp_stores_templates.all_categories') }}</h3>
                </div>
                <div>
                    @foreach ($categories as $category)

                        <div class="form-check mb-2">
                            <input class="form-check-input {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'float-end' : '' }}" type="checkbox" wire:model.live="categoryFilter"
                                value="{{ $category->id }}"   name="flexcheckboxDefault"

                                id="flexcheckboxCategory-{{ $category->id }}" checked />
                            <label class="form-check-label fs-20 fw-5 text-black lh-sm {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'me-4' : '' }}"

                                for="flexcheckboxCategory-{{ $category->id }}">
                                {{ $category->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-3">
                <button type="button" wire:click="resetFilters" class="apply-btn btn btn-primary w-100">
                    {{ __('messages.whatsapp_stores_templates.reset_filters') }}
                </button>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-lg-8">
        <div class="row justify-content-end">
            <div class="col-xl-4 col-sm-6 mb-20">
                <div class="position-relative">
                    <input type="search" placeholder="{{ __('messages.whatsapp_stores_templates.search_products') }}"
                        wire:model.live="search" class="form-control ps-45" />
                    <div class="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M15 8.33317C15 10.1013 14.2976 11.797 13.0474 13.0472C11.7972 14.2975 10.1015 14.9998 8.33335 14.9998C6.56524 14.9998 4.86955 14.2975 3.61931 13.0472C2.36907 11.797 1.66669 10.1013 1.66669 8.33317C1.66669 6.56506 2.36907 4.86937 3.61931 3.61913C4.86955 2.36888 6.56524 1.6665 8.33335 1.6665C10.1015 1.6665 11.7972 2.36888 13.0474 3.61913C14.2976 4.86937 15 6.56506 15 8.33317ZM13.75 8.33317C13.75 9.76976 13.1793 11.1475 12.1635 12.1633C11.1477 13.1792 9.76994 13.7498 8.33335 13.7498C6.89676 13.7498 5.51901 13.1792 4.50319 12.1633C3.48737 11.1475 2.91669 9.76976 2.91669 8.33317C2.91669 6.89658 3.48737 5.51883 4.50319 4.50301C5.51901 3.48719 6.89676 2.9165 8.33335 2.9165C9.76994 2.9165 11.1477 3.48719 12.1635 4.50301C13.1793 5.51883 13.75 6.89658 13.75 8.33317Z"
                                fill="#999999" />
                            <path
                                d="M17.1084 16.225L14.1917 13.3083C14.1345 13.2469 14.0655 13.1976 13.9888 13.1635C13.9121 13.1293 13.8294 13.111 13.7455 13.1095C13.6615 13.108 13.5782 13.1234 13.5004 13.1549C13.4225 13.1863 13.3518 13.2331 13.2925 13.2924C13.2331 13.3518 13.1864 13.4225 13.1549 13.5003C13.1235 13.5781 13.1081 13.6615 13.1095 13.7454C13.111 13.8293 13.1294 13.9121 13.1635 13.9887C13.1977 14.0654 13.247 14.1344 13.3084 14.1916L16.225 17.1083C16.2822 17.1697 16.3512 17.219 16.4279 17.2531C16.5046 17.2873 16.5873 17.3056 16.6713 17.3071C16.7552 17.3086 16.8385 17.2932 16.9164 17.2617C16.9942 17.2303 17.0649 17.1835 17.1242 17.1242C17.1836 17.0648 17.2304 16.9941 17.2618 16.9163C17.2932 16.8385 17.3087 16.7551 17.3072 16.6712C17.3057 16.5873 17.2873 16.5045 17.2532 16.4278C17.219 16.3512 17.1698 16.2822 17.1084 16.225Z"
                                fill="#999999" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-20" wire:ignore>
                <div class="custom-select-container position-relative">
                    <div class="custom-select">
                        <div
                            class="custom-select-box fs-14 fw-6 text-black d-flex align-items-center position-relative">
                            <!-- SVG Icon Inside the Box -->
                            <div class="custom-arrow-select position-absolute d-flex align-items-center {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'rtl-arrow' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 20 20" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.41086 6.91098C4.25463 7.06725 4.16687 7.27918 4.16687 7.50015C4.16687 7.72112 4.25463 7.93304 4.41086 8.08931L9.41086 13.0893C9.56713 13.2455 9.77906 13.3333 10 13.3333C10.221 13.3333 10.4329 13.2455 10.5892 13.0893L15.5892 8.08931C15.741 7.93215 15.825 7.72164 15.8231 7.50315C15.8212 7.28465 15.7335 7.07564 15.579 6.92113C15.4245 6.76663 15.2155 6.67898 14.997 6.67709C14.7785 6.67519 14.568 6.75918 14.4109 6.91098L10 11.3218L5.58919 6.91098C5.43292 6.75476 5.221 6.66699 5.00003 6.66699C4.77906 6.66699 4.56713 6.75476 4.41086 6.91098Z"
                                        fill="currentColor" />
                                </svg>
                            </div>
                            <!-- Text for Select Price Range -->
                            <span
                                class="select-text">{{ __('messages.whatsapp_stores_templates.search_price_range') }}</span>
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
            </div>
        </div>
        <div class="section-heading position-relative">
            <h2>{{ __('messages.whatsapp_stores_templates.all_items') }}</h2>
        </div>
        <div class="row mb-40 product-section">
            @foreach ($products as $product)
                <div class="col-xl-3 col-sm-6 mb-20">
                    <div class="h-100 product-card d-flex flex-column">
                        <a href="{{ route('whatsapp.store.product.details', [$urlAlias, $product->id]) }}"
                            class="d-flex flex-column h-100 text-black">
                            <div class="product-img w-100 h-100 m-auto">
                                <img src="{{ $product->images_url[0] ?? '' }}" alt="product"
                                    class="w-100 h-100 object-fit-cover product-image" />
                            </div>

                        <div class="product-details" style="flex-grow: 1;">
                            <div class="d-flex justify-content-between h-100 flex-column">
                                <div>
                                    <h5 class="fs-20 fw-6 mb-1 product-name">{{ $product->name }}</h5>
                                    <p class="fs-14 fw-5 mb-2 text-gray-200 lh-sm product-category">
                                        {{ $product->category->name }}</p>
                                </div>
                                <div class="d-flex gap-2 align-items-center justify-content-between">
                                    <p class="fs-30 fw-6 lh-sm mb-0">
                                            <span class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                                        @if ($product->net_price)
                                            <del class="fs-20 fw-5 text-gray-200 text-nowrap">{{ currencyFormat($product->net_price, 2, $product->currency->currency_code) }}</del>
                                        @endif
                                    </p>

                                    <button data-id="{{ $product->id }}"
                                        class="@if($product->available_stock == 0) disabled @endif btn btn-primary d-flex justify-content-center align-items-center addToCartBtn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 30 30" fill="none">
                                            <path
                                                d="M23.6158 19.0898L24.4896 14.3458C24.5087 14.246 24.503 14.1431 24.4731 14.046C24.4432 13.9489 24.39 13.8606 24.3181 13.7888C24.2462 13.7171 24.1578 13.664 24.0606 13.6343C23.9635 13.6046 23.8605 13.5991 23.7608 13.6184C23.3462 13.7058 22.9237 13.7499 22.5 13.75C20.9414 13.75 19.4389 13.1676 18.2875 12.1171C17.136 11.0666 16.4185 9.62377 16.2758 8.07164C16.2626 7.91607 16.1917 7.77107 16.0769 7.66525C15.9621 7.55943 15.8118 7.50047 15.6557 7.5H6.8555L6.76503 7.09289C6.67249 6.67657 6.44076 6.30424 6.10809 6.03737C5.77541 5.7705 5.36169 5.62504 4.9352 5.625H3.15823C2.84686 5.625 2.55835 5.8377 2.50831 6.14502C2.49311 6.23471 2.49765 6.32663 2.52162 6.41438C2.54559 6.50214 2.58842 6.5836 2.64711 6.65311C2.7058 6.72261 2.77894 6.77847 2.86144 6.8168C2.94394 6.85513 3.03381 6.87501 3.12477 6.87504H4.93473C5.0771 6.87439 5.21538 6.92261 5.32647 7.01165C5.43756 7.10069 5.51474 7.22515 5.54511 7.36424L8.93428 22.6162C8.43929 22.7715 8.00475 23.0767 7.69073 23.4897C7.37672 23.9026 7.19874 24.4029 7.18139 24.9214C7.16404 25.4399 7.30818 25.951 7.59389 26.384C7.8796 26.8171 8.29276 27.1506 8.77627 27.3387C9.25978 27.5267 9.78976 27.5599 10.293 27.4337C10.7962 27.3075 11.2477 27.028 11.5852 26.634C11.9227 26.2401 12.1295 25.751 12.177 25.2343C12.2245 24.7177 12.1103 24.1991 11.8503 23.7502H19.7123C19.4374 24.2267 19.3275 24.7805 19.3996 25.3258C19.4716 25.8711 19.7216 26.3774 20.1107 26.7662C20.4998 27.1549 21.0064 27.4044 21.5517 27.4759C22.0971 27.5474 22.6508 27.437 23.127 27.1617C23.6032 26.8864 23.9753 26.4617 24.1855 25.9534C24.3957 25.4451 24.4323 24.8817 24.2896 24.3505C24.147 23.8192 23.833 23.35 23.3964 23.0154C22.9598 22.6808 22.425 22.4996 21.875 22.5H10.189L9.77229 20.625H21.7719C22.2102 20.625 22.6347 20.4714 22.9715 20.191C23.3084 19.9105 23.5363 19.5209 23.6158 19.0898ZM9.68751 25.9375C9.50209 25.9375 9.32083 25.8825 9.16666 25.7795C9.01249 25.6765 8.89233 25.5301 8.82137 25.3588C8.75041 25.1875 8.73185 24.999 8.76802 24.8171C8.80419 24.6353 8.89348 24.4682 9.02459 24.3371C9.15571 24.206 9.32275 24.1167 9.50461 24.0805C9.68647 24.0444 9.87497 24.0629 10.0463 24.1339C10.2176 24.2048 10.364 24.325 10.467 24.4792C10.57 24.6333 10.625 24.8146 10.625 25C10.625 25.2487 10.5262 25.4871 10.3504 25.6629C10.1746 25.8387 9.93615 25.9375 9.68751 25.9375ZM22.8125 25C22.8125 25.1854 22.7575 25.3667 22.6545 25.5209C22.5515 25.675 22.4051 25.7952 22.2338 25.8662C22.0625 25.9371 21.874 25.9557 21.6921 25.9195C21.5103 25.8833 21.3432 25.794 21.2121 25.6629C21.081 25.5318 20.9917 25.3648 20.9555 25.1829C20.9193 25.0011 20.9379 24.8126 21.0089 24.6413C21.0798 24.4699 21.2 24.3235 21.3542 24.2205C21.5083 24.1175 21.6896 24.0625 21.875 24.0625C22.1236 24.0625 22.3621 24.1613 22.5379 24.3371C22.7137 24.5129 22.8125 24.7514 22.8125 25Z"
                                                fill="currentColor" />
                                            <path
                                                d="M22.5 2.5C21.5111 2.5 20.5444 2.79324 19.7221 3.34265C18.8999 3.89205 18.259 4.67294 17.8806 5.58657C17.5022 6.5002 17.4031 7.50553 17.5961 8.47543C17.789 9.44533 18.2652 10.3362 18.9645 11.0355C19.6637 11.7348 20.5546 12.211 21.5245 12.4039C22.4944 12.5968 23.4998 12.4978 24.4134 12.1194C25.327 11.7409 26.1079 11.1001 26.6573 10.2778C27.2067 9.45558 27.5 8.48888 27.5 7.49998C27.4999 6.17391 26.9732 4.90215 26.0355 3.96448C25.0978 3.0268 23.8261 2.50002 22.5 2.5ZM24.6875 8.125H23.125V9.68752C23.1258 9.7701 23.1102 9.85203 23.0792 9.92856C23.0481 10.0051 23.0022 10.0747 22.9441 10.1334C22.886 10.1921 22.8168 10.2386 22.7406 10.2704C22.6644 10.3022 22.5826 10.3186 22.5 10.3186C22.4174 10.3186 22.3357 10.3022 22.2594 10.2704C22.1832 10.2386 22.114 10.1921 22.0559 10.1334C21.9978 10.0747 21.9519 10.0051 21.9208 9.92856C21.8898 9.85203 21.8742 9.7701 21.875 9.68752V8.125H20.3125C20.2299 8.1258 20.148 8.11022 20.0715 8.07917C19.9949 8.04812 19.9253 8.00221 19.8666 7.9441C19.808 7.88598 19.7614 7.81682 19.7296 7.74059C19.6978 7.66437 19.6814 7.5826 19.6814 7.50001C19.6814 7.41742 19.6978 7.33565 19.7296 7.25943C19.7614 7.1832 19.808 7.11403 19.8666 7.05592C19.9253 6.9978 19.9949 6.9519 20.0715 6.92085C20.148 6.8898 20.2299 6.87422 20.3125 6.87502H21.875V5.3125C21.8742 5.22992 21.8898 5.14799 21.9208 5.07146C21.9519 4.99493 21.9978 4.92532 22.0559 4.86664C22.114 4.80796 22.1832 4.76138 22.2594 4.72959C22.3357 4.6978 22.4174 4.68143 22.5 4.68143C22.5826 4.68143 22.6644 4.6978 22.7406 4.72959C22.8168 4.76138 22.886 4.80796 22.9441 4.86664C23.0022 4.92532 23.0481 4.99493 23.0792 5.07146C23.1102 5.14799 23.1258 5.22992 23.125 5.3125V6.87502H24.6875C24.8522 6.87661 25.0097 6.94316 25.1256 7.0602C25.2415 7.17723 25.3065 7.33529 25.3065 7.50001C25.3065 7.66473 25.2415 7.82279 25.1256 7.93982C25.0097 8.05686 24.8522 8.12341 24.6875 8.125H24.6875Z"
                                                fill="currentColor" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </a>
                    </div>
                </div>
            @endforeach
            <div class="mt-4 d-flex justify-content-center custom-pagination">
                {{ $products->links() }}
            </div>
            @if ($products->count() == 0)
                <div>
                    <h2 class="text-center">{{ __('messages.whatsapp_stores.no_product_found') }}</h2>
                </div>
            @endif
        </div>

    </div>

</div>
