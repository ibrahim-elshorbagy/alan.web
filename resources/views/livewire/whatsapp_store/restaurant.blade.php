<div class="row">
    <div class="col-xl-3 col-lg-4  mb-40">
        <div class="items-tabs">
            <div class="position-relative mb-22">
                <div class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15 8.33332C15 10.1014 14.2976 11.7971 13.0473 13.0474C11.7971 14.2976 10.1014 15 8.33329 15C6.56518 15 4.86949 14.2976 3.61925 13.0474C2.369 11.7971 1.66663 10.1014 1.66663 8.33332C1.66663 6.56521 2.369 4.86952 3.61925 3.61928C4.86949 2.36904 6.56518 1.66666 8.33329 1.66666C10.1014 1.66666 11.7971 2.36904 13.0473 3.61928C14.2976 4.86952 15 6.56521 15 8.33332ZM13.75 8.33332C13.75 9.76991 13.1793 11.1477 12.1635 12.1635C11.1476 13.1793 9.76988 13.75 8.33329 13.75C6.8967 13.75 5.51895 13.1793 4.50313 12.1635C3.48731 11.1477 2.91663 9.76991 2.91663 8.33332C2.91663 6.89673 3.48731 5.51898 4.50313 4.50316C5.51895 3.48734 6.8967 2.91666 8.33329 2.91666C9.76988 2.91666 11.1476 3.48734 12.1635 4.50316C13.1793 5.51898 13.75 6.89673 13.75 8.33332Z"
                            fill="#F2F2F2" />
                        <path
                            d="M17.1083 16.225L14.1916 13.3083C14.1344 13.2469 14.0654 13.1977 13.9887 13.1635C13.9121 13.1294 13.8293 13.111 13.7454 13.1095C13.6615 13.108 13.5781 13.1235 13.5003 13.1549C13.4225 13.1863 13.3518 13.2331 13.2924 13.2925C13.2331 13.3518 13.1863 13.4225 13.1549 13.5003C13.1234 13.5782 13.108 13.6615 13.1095 13.7454C13.111 13.8294 13.1293 13.9121 13.1635 13.9888C13.1976 14.0654 13.2469 14.1344 13.3083 14.1917L16.225 17.1083C16.2822 17.1697 16.3512 17.219 16.4279 17.2531C16.5045 17.2873 16.5873 17.3057 16.6712 17.3072C16.7551 17.3086 16.8385 17.2932 16.9163 17.2618C16.9941 17.2303 17.0648 17.1835 17.1242 17.1242C17.1835 17.0648 17.2303 16.9942 17.2617 16.9163C17.2932 16.8385 17.3086 16.7551 17.3071 16.6712C17.3056 16.5873 17.2873 16.5045 17.2531 16.4279C17.219 16.3512 17.1697 16.2822 17.1083 16.225Z"
                            fill="#F2F2F2" />
                    </svg>
                </div>
                <input type="search" placeholder="{{ __('messages.whatsapp_stores_templates.search_items') }}"
                    wire:model.live="search" class="form-control ps-45" />
            </div>
            <div class="row mx-0 mb-22 min-max-value">
                <div class="col-4 ps-0 px-1">
                    <input type="number" min="0" wire:model.defer="minPrice" class="form-control"
                        placeholder="{{ __('messages.whatsapp_stores_templates.min') }}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                </div>
                <div class="col-4 px-1">
                    <input type="number" min="1" class="form-control" wire:model.defer="maxPrice"
                        placeholder="{{ __('messages.whatsapp_stores_templates.max') }}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                </div>
                <div class="col-4 pe-0 px-1">
                    <button wire:click="applyPriceFilter" type="submit" class="apply-btn btn btn-primary w-100 h-100">
                        {{ __('messages.whatsapp_stores_templates.apply') }}
                    </button>
                </div>
            </div>
            <div class="mb-20 date-posted">
                <div class="heading-text mb-20">
                    <h3 class="mb-0 fs-18 fw-medium text-white">
                        {{ __('messages.whatsapp_stores_templates.date_posted') }}</h3>
                </div>
                <div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="flexcheckboxDefault"
                            id="flexcheckboxDefault1" wire:model.live="dateFilter" value="3_days" />
                        <label class="form-check-label fs-16 fw-medium text-black lh-sm text-white"
                            for="flexcheckboxDefault1">
                            3 {{ __('messages.whatsapp_stores_templates.days_ago') }}
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="flexcheckboxDefault"
                            id="flexcheckboxDefault2" wire:model.live="dateFilter" value="1_week" />
                        <label class="form-check-label fs-16 fw-medium text-black lh-sm text-white"
                            for="flexcheckboxDefault2">
                            1 {{ __('messages.whatsapp_stores_templates.week_ago') }}
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="flexcheckboxDefault"
                            id="flexcheckboxDefault3" wire:model.live="dateFilter" value="1_month" />
                        <label class="form-check-label fs-16 fw-medium text-black lh-sm text-white"
                            for="flexcheckboxDefault3">
                            1 {{ __('messages.whatsapp_stores_templates.month_ago') }}
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="flexcheckboxDefault"
                            wire:model.live="dateFilter" value="6_months" id="flexcheckboxDefault4" />
                        <label class="form-check-label fs-16 fw-medium text-black lh-sm text-white"
                            for="flexcheckboxDefault4">
                            6 {{ __('messages.whatsapp_stores_templates.months_ago') }}
                        </label>
                    </div>
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="radio" name="flexcheckboxDefault"
                            wire:model.live="dateFilter" value="1_year" id="flexcheckboxDefault5" />
                        <label class="form-check-label fs-16 fw-medium text-black lh-sm text-white"
                            for="flexcheckboxDefault5">
                            1 {{ __('messages.whatsapp_stores_templates.year_ago') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="mb-22">
                <div class="heading-text mb-20">
                    <h3 class="mb-0 fs-18 fw-medium text-white">
                        {{ __('messages.whatsapp_stores_templates.search_price_range') }}</h3>
                </div>
                <div class="custom-select-container position-relative" wire:ignore>
                    <div class="custom-select">
                        <div
                            class="custom-select-box fs-14 fw-6 text-black d-flex align-items-center position-relative">
                            <!-- SVG Icon Inside the Box -->
                            <div class="custom-arrow-select position-absolute d-flex align-items-center"
                                style="right: 10px;">
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
                            <div class="custom-select-option fs-14 fw-6 drop-item-select"
                                wire:click.prevent="setPriceSortOrder('1')" data-value="1">
                                {{ __('messages.whatsapp_stores_templates.low_to_high') }}</div>
                            <div class="custom-select-option fs-14 fw-6 drop-item-select"
                                wire:click.prevent="setPriceSortOrder('2')" data-value="2">
                                {{ __('messages.whatsapp_stores_templates.high_to_low') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="date-posted">
                <div class="heading-text mb-20">
                    <h3 class="mb-0 fs-18 fw-medium text-white">
                        {{ __('messages.whatsapp_stores_templates.all_categories') }}</h3>
                </div>
                <div>
                    @foreach ($categories as $category)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" wire:model.live="categoryFilter"
                                value="{{ $category->id }}" name="flexcheckboxDefault"
                                id="flexcheckboxCategory-{{ $category->id }}" />
                            <label class="form-check-label fs-16 fw-medium text-black lh-sm text-white"
                                for="flexcheckboxCategory-{{ $category->id }}">
                                {{ $category->name }}
                            </label>
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
    <div class="col-xl-9 col-lg-8  mb-40">
        <div class="row row-gap-30px mb-100px">
            @foreach ($products as $product)
                <div class="col-lg-3 col-sm-6">
                    <div class="product-card d-flex justify-content-between flex-column h-100 gap-4">
                        <a class="d-flex justify-content-between flex-column"
                            href="{{ route('whatsapp.store.product.details', [$urlAlias, $product->id]) }}">
                            <div>
                                <div class="product-img">
                                    <img src="{{ $product->images_url[0] ?? '' }}" alt="product-img"
                                        class="h-100 w-100 ovject-fit-cover product-image" loading="lazy" />
                                </div>
                                <div class="product-details">
                                    <input type="hidden" value=" {{ $product->category->name }}"
                                        class="product-category">
                                    <p class="fs-18 fw-normal text-white text-center mb-0 product-name">
                                        {{ $product->name }}</p>
                                    <p class="text-primary fs-20 fw-semibold text-center mb-0">
                                        <span class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                        <button
                            class="@if($product->available_stock == 0) disabled @endif btn btn-primary d-flex justify-content-center align-items-center w-100 mx-auto addToCartBtn"
                            data-id="{{ $product->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                viewBox="0 0 28 28" class="me-1">
                                <path
                                    d="M13.5264 20.4167C13.5262 21.5727 13.8127 22.7108 14.3605 23.7288C14.9082 24.7469 15.6999 25.6132 16.6647 26.25H4.50225C4.08859 26.2504 3.67958 26.1628 3.30243 25.9929C2.92529 25.8229 2.58865 25.5746 2.31493 25.2645C2.04121 24.9544 1.83667 24.5895 1.71494 24.1941C1.59321 23.7988 1.55706 23.3821 1.60892 22.9717L3.35892 8.97167C3.44705 8.26638 3.78969 7.61755 4.32247 7.14708C4.85524 6.6766 5.54148 6.41687 6.25225 6.41667H7.69308V9.91667C7.69308 10.0714 7.75454 10.2197 7.86394 10.3291C7.97333 10.4385 8.12171 10.5 8.27642 10.5C8.43112 10.5 8.5795 10.4385 8.68889 10.3291C8.79829 10.2197 8.85975 10.0714 8.85975 9.91667V6.41667H15.8597V9.91667C15.8597 10.0714 15.9212 10.2197 16.0306 10.3291C16.14 10.4385 16.2884 10.5 16.4431 10.5C16.5978 10.5 16.7462 10.4385 16.8556 10.3291C16.965 10.2197 17.0264 10.0714 17.0264 9.91667V6.41667H18.4672C19.178 6.41687 19.8643 6.6766 20.397 7.14708C20.9298 7.61755 21.2724 8.26638 21.3606 8.97167L21.9322 13.5567C20.9149 13.3503 19.8645 13.3723 18.8567 13.6212C17.8489 13.8702 16.909 14.3397 16.1048 14.9961C15.3006 15.6524 14.6521 16.4791 14.2062 17.4165C13.7603 18.3539 13.5281 19.3786 13.5264 20.4167ZM17.0264 6.41667H15.8597C15.8597 5.48841 15.491 4.59817 14.8346 3.94179C14.1782 3.28542 13.288 2.91667 12.3597 2.91667C11.4315 2.91667 10.5413 3.28542 9.88487 3.94179C9.2285 4.59817 8.85975 5.48841 8.85975 6.41667H7.69308C7.69308 5.17899 8.18475 3.992 9.05992 3.11683C9.93509 2.24167 11.1221 1.75 12.3597 1.75C13.5974 1.75 14.7844 2.24167 15.6596 3.11683C16.5347 3.992 17.0264 5.17899 17.0264 6.41667Z"
                                    fill="currentColor" />
                                <path
                                    d="M20.5264 14.5834C19.3727 14.5834 18.2449 14.9255 17.2856 15.5665C16.3263 16.2074 15.5786 17.1185 15.1371 18.1844C14.6956 19.2503 14.5801 20.4232 14.8052 21.5547C15.0303 22.6863 15.5858 23.7257 16.4016 24.5415C17.2174 25.3573 18.2568 25.9129 19.3884 26.138C20.5199 26.363 21.6928 26.2475 22.7587 25.806C23.8246 25.3645 24.7357 24.6168 25.3767 23.6575C26.0176 22.6982 26.3598 21.5704 26.3598 20.4167C26.3581 18.8701 25.7429 17.3874 24.6493 16.2938C23.5557 15.2002 22.073 14.5851 20.5264 14.5834ZM22.2764 21H21.1098V22.1667C21.1098 22.3214 21.0483 22.4698 20.9389 22.5792C20.8295 22.6886 20.6811 22.75 20.5264 22.75C20.3717 22.75 20.2233 22.6886 20.1139 22.5792C20.0045 22.4698 19.9431 22.3214 19.9431 22.1667V21H18.7764C18.6217 21 18.4733 20.9386 18.3639 20.8292C18.2545 20.7198 18.1931 20.5714 18.1931 20.4167C18.1931 20.262 18.2545 20.1136 18.3639 20.0042C18.4733 19.8948 18.6217 19.8334 18.7764 19.8334H19.9431V18.6667C19.9431 18.512 20.0045 18.3636 20.1139 18.2542C20.2233 18.1448 20.3717 18.0834 20.5264 18.0834C20.6811 18.0834 20.8295 18.1448 20.9389 18.2542C21.0483 18.3636 21.1098 18.512 21.1098 18.6667V19.8334H22.2764C22.4311 19.8334 22.5795 19.8948 22.6889 20.0042C22.7983 20.1136 22.8598 20.262 22.8598 20.4167C22.8598 20.5714 22.7983 20.7198 22.6889 20.8292C22.5795 20.9386 22.4311 21 22.2764 21Z"
                                    fill="currentColor" />
                            </svg>
                            {{ __('messages.whatsapp_stores_templates.add_to_cart') }}
                        </button>
                    </div>
                </div>
            @endforeach
            <div class="mt-4 d-flex justify-content-center custom-pagination">
                {{ $products->links() }}
            </div>
            @if ($products->count() == 0)
                <div>
                    <h2 class="text-center text-white">{{ __('messages.whatsapp_stores.no_items_found') }}</h2>
                </div>
            @endif
        </div>
    </div>
</div>
