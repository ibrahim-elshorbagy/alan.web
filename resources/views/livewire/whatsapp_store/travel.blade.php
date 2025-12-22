<div class="product-filter-section position-relative">
    <div class="row">
        <div class="col-lg-4 col-xl-3 right-part">
            <div class="search-tour p-20 custom-card">
                <h5 class="fs-18 fw-medium text-black leading-104">
                    {{ __('messages.whatsapp_stores_templates.search_tours') }}
                </h5>
                    <div class="position-relative pt-4">
                        <div class="search-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M14.8752 8.37537C14.8752 10.0993 14.1904 11.7526 12.9714 12.9716C11.7525 14.1905 10.0992 14.8754 8.37524 14.8754C6.65134 14.8754 4.99804 14.1905 3.77905 12.9716C2.56006 11.7526 1.87524 10.0993 1.87524 8.37537C1.87524 6.65146 2.56006 4.99816 3.77905 3.77917C4.99804 2.56019 6.65134 1.87537 8.37524 1.87537C10.0992 1.87537 11.7525 2.56019 12.9714 3.77917C14.1904 4.99816 14.8752 6.65146 14.8752 8.37537ZM13.6565 8.37537C13.6565 9.77604 13.1001 11.1193 12.1097 12.1098C11.1192 13.1002 9.77592 13.6566 8.37524 13.6566C6.97457 13.6566 5.63126 13.1002 4.64084 12.1098C3.65041 11.1193 3.09399 9.77604 3.09399 8.37537C3.09399 6.97469 3.65041 5.63138 4.64084 4.64096C5.63126 3.65053 6.97457 3.09412 8.37524 3.09412C9.77592 3.09412 11.1192 3.65053 12.1097 4.64096C13.1001 5.63138 13.6565 6.97469 13.6565 8.37537Z"
                                    fill="black" />
                                <path
                                    d="M16.9307 16.0696L14.0869 13.2258C14.0312 13.1659 13.9639 13.1179 13.8891 13.0846C13.8144 13.0513 13.7337 13.0334 13.6519 13.032C13.57 13.0305 13.4888 13.0456 13.4129 13.0762C13.337 13.1069 13.2681 13.1525 13.2102 13.2103C13.1524 13.2682 13.1067 13.3371 13.0761 13.413C13.0454 13.4889 13.0304 13.5702 13.0318 13.652C13.0333 13.7338 13.0512 13.8145 13.0845 13.8892C13.1178 13.964 13.1658 14.0313 13.2257 14.0871L16.0694 16.9308C16.1252 16.9907 16.1925 17.0387 16.2673 17.072C16.342 17.1053 16.4227 17.1232 16.5045 17.1247C16.5863 17.1261 16.6676 17.1111 16.7435 17.0804C16.8194 17.0498 16.8883 17.0041 16.9462 16.9463C17.004 16.8884 17.0496 16.8195 17.0803 16.7436C17.1109 16.6677 17.126 16.5865 17.1245 16.5046C17.1231 16.4228 17.1052 16.3421 17.0719 16.2674C17.0386 16.1926 16.9906 16.1253 16.9307 16.0696Z"
                                    fill="black" />
                            </svg>
                        </div>
                        <input type="search"
                               placeholder="{{ __('messages.whatsapp_stores_templates.search_items_tours') }}"
                               wire:model.live="search"
                               class="form-control ps-45" />
                    </div>
                    <div class="row mx-0 mb-20 min-max-value position-relative pt-4">
                        <div class="col-4 ps-0 px-1">
                            <input type="number" min="0" wire:model.defer="minPrice" class="form-control" style="font-size: 14px"
                                   placeholder="{{ __('messages.whatsapp_stores_templates.min') }}"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                        </div>
                        <div class="col-4 px-1">
                            <input type="number" min="1" wire:model.defer="maxPrice" class="form-control" style="font-size: 14px"
                                   placeholder="{{ __('messages.whatsapp_stores_templates.max') }}"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                        </div>
                        <div class="col-4 pe-0 px-1 apply-button">
                            <button wire:click="applyPriceFilter" type="submit" class="apply-btn btn  w-100 h-100" style="font-size: 14px">
                                {{ __('messages.whatsapp_stores_templates.apply') }}
                            </button>
                        </div>

                    </div>
            </div>
            <div class="filter p-20 custom-card">
                <h5 class="fs-18 fw-medium text-black leading-104 mb-22">{{ __('messages.common.filter') }}</h5>
                <div class="mt-22">
                    <h4 class="fw-medium text-black fs-16 leading-104 mb-4">{{ __('messages.whatsapp_stores_templates.all_categories') }}</h4>
                    @foreach ($whatsappStore->categories as $category)
                        <label class="custom-checkbox mb-3 d-flex align-items-center">
                            <input type="checkbox" wire:model.live="categoryFilter"
                                   value="{{ $category->id }}"
                                   name="flexcheckboxDefault"
                                   id="flexcheckboxCategory{{ $category->id }}" />
                            <span class="checkmark"></span>
                            <span class="fs-16 fw-medium lh-sm text-gray-100">{{ $category->name }}</span>
                        </label>
                    @endforeach

                    <div class="mb-20 pt-2 date-posted">
                        <div class="heading-text mb-20">
                            <h3 class="mb-4 fs-18 fw-medium text-black">{{ __('messages.whatsapp_stores_templates.date_posted') }}</h3>
                        </div>
                        <div>
                            <label class="custom-checkbox mb-3 d-flex align-items-center">
                                <input type="radio" wire:model.live="dateFilter"
                                       value="3_days" name="dateFilter" id="flexcheckbox1" />
                                <span class="checkmark"></span>
                                <span class="fs-16 fw-medium text-gray-100 lh-sm">
                                    3 {{ __('messages.whatsapp_stores_templates.days_ago') }}
                                </span>
                            </label>

                            <label class="custom-checkbox mb-3 d-flex align-items-center">
                                <input type="radio" wire:model.live="dateFilter"
                                       value="1_week" name="dateFilter" id="flexcheckbox2" />
                                <span class="checkmark"></span>
                                <span class="fs-16 fw-medium text-gray-100 lh-sm">
                                    1 {{ __('messages.whatsapp_stores_templates.week_ago') }}
                                </span>
                            </label>

                            <label class="custom-checkbox mb-3 d-flex align-items-center">
                                <input type="radio" wire:model.live="dateFilter"
                                       value="1_month" name="dateFilter" id="flexcheckbox3" />
                                <span class="checkmark"></span>
                                <span class="fs-16 fw-medium text-gray-100 lh-sm">
                                    1 {{ __('messages.whatsapp_stores_templates.month_ago') }}
                                </span>
                            </label>

                            <label class="custom-checkbox mb-3 d-flex align-items-center">
                                <input type="radio" wire:model.live="dateFilter"
                                       value="6_months" name="dateFilter" id="flexcheckbox4" />
                                <span class="checkmark"></span>
                                <span class="fs-16 fw-medium text-gray-100 lh-sm">
                                    6 {{ __('messages.whatsapp_stores_templates.months_ago') }}
                                </span>
                            </label>

                            <label class="custom-checkbox mb-0 d-flex align-items-center">
                                <input type="radio" wire:model.live="dateFilter"
                                       value="1_year" name="dateFilter" id="flexcheckbox5" />
                                <span class="checkmark"></span>
                                <span class="fs-16 fw-medium text-gray-100 lh-sm">
                                    1 {{ __('messages.whatsapp_stores_templates.year_ago') }}
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-5 reset-button">
                    <button type="button" wire:click="resetFilters" class="btn w-100">{{ __('messages.whatsapp_stores_templates.reset_filters') }}</button>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xl-9 left-part mt-5 mt-lg-0">
            <div class="fs-16 d-flex align-items-center justify-content-end flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="custom-select-container position-relative mb-20 pt-4 w-100">
                            <div class="custom-select">
                                <div class="custom-select-box fs-20 text-gray fw-medium leading-104 d-flex align-items-center position-relative">
                                    <div class="custom-arrow-select position-absolute d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4.41098 6.91098C4.25476 7.06725 4.16699 7.27918 4.16699 7.50015C4.16699 7.72112 4.25476 7.93304 4.41098 8.08931L9.41098 13.0893C9.56725 13.2455 9.77918 13.3333 10.0001 13.3333C10.2211 13.3333 10.433 13.2455 10.5893 13.0893L15.5893 8.08931C15.7411 7.93215 15.8251 7.72164 15.8232 7.50315C15.8213 7.28465 15.7337 7.07564 15.5792 6.92113C15.4247 6.76663 15.2156 6.67898 14.9971 6.67709C14.7787 6.67519 14.5681 6.75918 14.411 6.91098L10.0001 11.3218L5.58931 6.91098C5.43304 6.75476 5.22112 6.66699 5.00015 6.66699C4.77918 6.66699 4.56725 6.75476 4.41098 6.91098Z"
                                                fill="#27262E" />
                                        </svg>
                                    </div>
                                    <span class="select-text fs-20 fw-5 lh-1">
                                        @if($priceSortOrder == '1')
                                            {{ __('messages.whatsapp_stores_templates.low_to_high') }}
                                        @elseif($priceSortOrder == '2')
                                            {{ __('messages.whatsapp_stores_templates.high_to_low') }}
                                        @else
                                            {{ __('messages.whatsapp_stores_templates.search_price_range') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="custom-select-options">
                                    <div class="custom-select-option fs-14 fw-6 text-black drop-item-select"
                                         wire:click.prevent="setPriceSortOrder('1')" data-value="1">
                                        {{ __('messages.whatsapp_stores_templates.low_to_high') }}
                                    </div>
                                    <div class="custom-select-option fs-14 fw-6 text-black drop-item-select"
                                         wire:click.prevent="setPriceSortOrder('2')" data-value="2">
                                        {{ __('messages.whatsapp_stores_templates.high_to_low') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="line"></div>
            <div class="d-flex flex-column row-gap-40">
                @foreach ($products as $product)
                    <div class="product-card d-flex flex-column flex-sm-row custom-card" style="align-items: stretch;">
                        <a href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}" class="text-decoration-none">
                            <div class="card-img">
                                <img src="{{ $product->images_url[0] ?? '' }}" alt="img" class="w-100 h-100 object-fit-cover" />
                            </div>
                        </a>
                        <div class="card-content d-flex flex-column h-100 w-100 pt-5">
                            <div class="flex-grow-1">
                                <div class="mb-3 pb-2">
                                    <h4 class="fs-20 fw-medium text-black leading-104">{{ $product->name }}</h4>
                                    <p class="text-gray fs-16 fw-medium leading-104 d-flex gap-10 location">
                                        {{ $product->category->name }}
                                    </p>
                                </div>
                                <p class="text-gray font-normal desc">{{ Str::limit(strip_tags($product->description) ?? '', 200) }}</p>
                            </div>
                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                                <div class="d-flex align-items-center card-title flex-wrap">
                                    @if ($product->net_price)
                                        <span class="fs-14 fw-semibold me-2" style="color: #B1B5C3">
                                            <del>{{ currencyFormat($product->net_price, 2, $product->currency->currency_code) }}</del>
                                        </span>
                                    @endif
                                    <span class="badge rounded-pill px-3 py-2 fs-16" style="background-color: #faeee6; color: #dc834e; border: 1px solid #dc834e; white-space: nowrap;">
                                        <span class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                                    </span>
                                </div>
                                    {{-- <span class="primary-text fs-20 fw-semibold">{{ $product->currency->currency_icon }}{{ $product->selling_price }}</span> --}}
                                <a href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}" class="fs-18 fs-md-20 fw-semibold primary-text text-nowrap align-self-end align-self-md-center">
                                    {{ __('messages.whatsapp_stores.explore') }}
                                    <span class="ms-1">
                                        <svg width="18" height="12" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="d-inline">
                                            <path d="M1.5 7H17.4993" stroke="#DC834E" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                                            <path d="M12.5 1L18.4997 6.99973L12.5 13" stroke="#DC834E" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-card d-flex justify-content-center custom-pagination">
                {{ $products->links() }}
            </div>
            @if ($products->count() == 0)
                <div class="no-items-found d-flex justify-content-center align-items-center" style="height: 50vh;">
                    <h2 class="mb-0 text-break">{{ __('messages.whatsapp_stores.no_package_found') }}</h2>
                </div>
            @endif
        </div>
    </div>
</div>
