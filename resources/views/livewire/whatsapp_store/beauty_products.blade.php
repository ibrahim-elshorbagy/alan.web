<div class="row mb-40">
    <div class="col-xl-3 col-lg-4 mb-40">
        <div class="items-tabs">
            <div class="row mx-0 mb-30">
                <div class="col-4 ps-0 px-1">
                    <input type="number" min="0" wire:model.defer="minPrice" class="form-control"
                        placeholder="{{ __('messages.whatsapp_stores_templates.min') }}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                </div>
                <div class="col-4 px-1">
                    <input type="number" min="1" wire:model.defer="maxPrice" class="form-control"
                        placeholder="{{ __('messages.whatsapp_stores_templates.max') }}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                </div>
                <div class="col-4 pe-0 px-1">
                    <button wire:click="applyPriceFilter" class="apply-btn btn btn-primary w-100">
                        {{ __('messages.whatsapp_stores_templates.apply') }}
                    </button>
                </div>
            </div>
            <div class="mb-30">
                <div class="heading-text mb-4">
                    <h3> {{ __('messages.whatsapp_stores_templates.date_posted') }}</h3>
                </div>
                <div>
                    <div class="form-check mb-2">
                        <input class="form-check-input {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'float-end' : '' }}" type="radio" name="flexRadioDefault" id="flexRadioDefault1"
                            wire:model.live="dateFilter" value="3_days" />
                        <label class="form-check-label fs-16 fw-5 {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'me-4' : '' }}" for="flexRadioDefault1">
                            3 {{ __('messages.whatsapp_stores_templates.days_ago') }}
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'float-end' : '' }}" type="radio" wire:model.live="dateFilter" value="1_week"
                            name="flexRadioDefault" id="flexRadioDefault2" />
                        <label class="form-check-label fs-16 fw-5 {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'me-4' : '' }}" for="flexRadioDefault2">
                            1 {{ __('messages.whatsapp_stores_templates.week_ago') }}
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'float-end' : '' }}" type="radio" wire:model.live="dateFilter" value="1_month"
                            name="flexRadioDefault" id="flexRadioDefault3" />
                        <label class="form-check-label fs-16 fw-5 {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'me-4' : '' }}" for="flexRadioDefault3">
                            1 {{ __('messages.whatsapp_stores_templates.month_ago') }}
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'float-end' : '' }}" type="radio" wire:model.live="dateFilter" value="6_months"
                            name="flexRadioDefault" id="flexRadioDefault4" />
                        <label class="form-check-label fs-16 fw-5 {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'me-4' : '' }}" for="flexRadioDefault4">
                            6 {{ __('messages.whatsapp_stores_templates.months_ago') }}
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'float-end' : '' }}" type="radio" wire:model.live="dateFilter" value="1_year"
                            name="flexRadioDefault" id="flexRadioDefault5" />
                        <label class="form-check-label fs-16 fw-5 {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'me-4' : '' }}" for="flexRadioDefault5">
                            1 {{ __('messages.whatsapp_stores_templates.year_ago') }}
                        </label>
                    </div>
                </div>
            </div>
            <div>
                <div class="heading-text mb-3">
                    <h3>{{ __('messages.whatsapp_stores_templates.all_categories') }}</h3>
                </div>
                <div>
                    @foreach ($categories as $category)
                        <div class="category-item">
                            <button
                            class="category-button w-100 {{ $categorySelected == $category->id ? 'active-category' : '' }}"
                                type="button" wire:click="setCategory({{ $category->id }})">
                                <div class="category-category-img">
                                    <img src="{{ $category->image_url }}" class="w-100 rounded" alt="category" />
                                </div>
                                <span class="text-start flex-grow-1"> {{ $category->name }}</span>
                            </button>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="mt-5">
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
                    <input type="text" wire:model.live="search"
                        placeholder="{{ __('messages.whatsapp_stores_templates.search_products') }}"
                        class="form-control ps-45" />
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
            <div class="col-xl-4 col-sm-6 mb-20" wire:ignore>
                <div class="dropdown">
                    <button class="serach-dropdown text-start w-100" type="button" id="customSelectBtn"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('messages.whatsapp_stores_templates.search_price_range') }}
                    </button>
                    <ul class="dropdown-menu w-100" id="customSelectMenu">
                        <li><a class="dropdown-item drop-item-select" href="#" wire:click.prevent="setPriceSortOrder('1')"
                                data-value="1">{{ __('messages.whatsapp_stores_templates.low_to_high') }}</a></li>
                        <li><a class="dropdown-item drop-item-select" href="#" wire:click.prevent="setPriceSortOrder('2')"
                                data-value="2">{{ __('messages.whatsapp_stores_templates.high_to_low') }}</a></li>

                    </ul>
                </div>

                <!-- Hidden Select Element -->
                <select id="hiddenSelect" class="d-none">
                    <option value="1">Price: Low to High</option>
                    <option value="2">Price: High to Low</option>
                </select>

            </div>
        </div>
        <div class="section-heading">
            <h2>{{ __('messages.whatsapp_stores_templates.all_items') }}</h2>
        </div>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-xl-3 col-sm-6 mb-20">
                    <div class="item-card h-100">
                        <div class="d-flex flex-column h-100">
                            <a href="{{ route('whatsapp.store.product.details', [$urlAlias, $product->id]) }}"
                                style="color: #212529;" class="d-block h-100">
                                <div class="flex-grow-1 h-100">
                                    <div class="item-img">
                                        <img src="{{ $product->images_url[0] ?? '' }}" alt="item"
                                            class="w-100 h-100 object-fit-cover product-image" />
                                    </div>
                                    <div class="item-details">

                                        <h5 class="fs-20 fw-6 mb-1 product-name">{{ $product->name }}</h5>

                                        <p class="fs-16 fw-5 mb-1 product-category">{{ $product->category->name }}</p>

                                        <p class="fs-18 fw-7">
                                            <span class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                                            @if ($product->net_price)
                                                <del class="fs-14 fw-7 text-gray-200">{{ currencyFormat($product->net_price, 2, $product->currency->currency_code) }}</del>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <button type="button" data-id="{{ $product->id }}"
                                class="@if($product->available_stock == 0) disabled @endif btn btn-primary d-flex justify-content-center align-items-center mx-auto gap-2 addToCartBtn">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25"
                                        viewBox="0 0 24 25" fill="none">
                                        <path
                                            d="M8.28564 7.41444C8.28564 5.36304 9.94849 3.7002 11.9999 3.7002C14.0513 3.7002 15.7141 5.36304 15.7141 7.41444C15.7141 7.56599 15.6539 7.71134 15.5468 7.8185C15.4396 7.92566 15.2943 7.98587 15.1427 7.98587C14.9912 7.98587 14.8458 7.92566 14.7387 7.8185C14.6315 7.71134 14.5713 7.56599 14.5713 7.41444C14.5713 6.73247 14.3004 6.07842 13.8181 5.59619C13.3359 5.11396 12.6819 4.84304 11.9999 4.84304C11.3179 4.84304 10.6639 5.11396 10.1816 5.59619C9.69941 6.07842 9.42849 6.73247 9.42849 7.41444C9.42849 7.56599 9.36829 7.71134 9.26112 7.8185C9.15396 7.92566 9.00862 7.98587 8.85707 7.98587C8.70552 7.98587 8.56017 7.92566 8.45301 7.8185C8.34585 7.71134 8.28564 7.56599 8.28564 7.41444ZM12.5713 12.5572C12.5713 12.4057 12.5111 12.2604 12.404 12.1532C12.2968 12.046 12.1514 11.9858 11.9999 11.9858C11.8483 11.9858 11.703 12.046 11.5958 12.1532C11.4887 12.2604 11.4285 12.4057 11.4285 12.5572V14.2715H9.7142C9.56265 14.2715 9.41731 14.3317 9.31014 14.4389C9.20298 14.546 9.14278 14.6914 9.14278 14.8429C9.14278 14.9945 9.20298 15.1398 9.31014 15.247C9.41731 15.3542 9.56265 15.4144 9.7142 15.4144H11.4285V17.1286C11.4285 17.2802 11.4887 17.4255 11.5958 17.5327C11.703 17.6399 11.8483 17.7001 11.9999 17.7001C12.1514 17.7001 12.2968 17.6399 12.404 17.5327C12.5111 17.4255 12.5713 17.2802 12.5713 17.1286V15.4144H14.2856C14.4371 15.4144 14.5825 15.3542 14.6896 15.247C14.7968 15.1398 14.857 14.9945 14.857 14.8429C14.857 14.6914 14.7968 14.546 14.6896 14.4389C14.5825 14.3317 14.4371 14.2715 14.2856 14.2715H12.5713V12.5572Z"
                                            fill="currentColor" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5.20225 10.7719C5.28737 10.234 5.56165 9.74422 5.97574 9.39058C6.38982 9.03693 6.91653 8.84268 7.46108 8.84277H16.5384C17.083 8.84261 17.6098 9.03683 18.0239 9.39049C18.4381 9.74414 18.7124 10.234 18.7975 10.7719L19.9715 18.2004C20.1907 19.5884 19.117 20.8427 17.7124 20.8427H6.28738C4.88282 20.8427 3.80912 19.5884 4.02854 18.2004L5.20225 10.7719ZM7.46108 9.98562C7.18873 9.98552 6.92529 10.0826 6.71814 10.2594C6.511 10.4363 6.37375 10.6812 6.33109 10.9502L5.1571 18.3787C5.13137 18.5419 5.14134 18.7088 5.18632 18.8678C5.23131 19.0269 5.31024 19.1742 5.41767 19.2998C5.52511 19.4254 5.65849 19.5262 5.80864 19.5952C5.95878 19.6643 6.12211 19.7 6.28738 19.6998H17.7124C17.8777 19.6999 18.041 19.6642 18.1911 19.5951C18.3412 19.5261 18.4746 19.4253 18.582 19.2997C18.6894 19.1741 18.7684 19.0268 18.8134 18.8678C18.8584 18.7088 18.8684 18.5419 18.8427 18.3787L17.6687 10.9502C17.626 10.6811 17.4887 10.4362 17.2815 10.2593C17.0743 10.0825 16.8108 9.98546 16.5384 9.98562H7.46108Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                {{ __('messages.whatsapp_stores_templates.add_to_cart') }}
                            </button>
                        </div>
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
</div>
