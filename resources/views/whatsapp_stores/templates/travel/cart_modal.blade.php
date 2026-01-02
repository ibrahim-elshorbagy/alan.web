<div class="modal fade product-modal" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column flex-md-row">
                <!-- Left Part - Product Details Table -->
                <div class="left-part">
                    <div class="custom-card p-20">
                        <div class="table-details overflow-auto h-100">
                            <table class="w-100">
                                <thead>
                                    <tr>
                                        <th class="fs-16 fw-medium text-black">{{ __('messages.whatsapp_stores.package') }}</th>
                                        <th class="fs-16 fw-medium text-black text-center text-nowrap">{{ __('messages.whatsapp_stores_templates.person') }}</th>
                                        <th class="fs-16 fw-medium text-black text-center text-nowrap">{{ __('messages.whatsapp_stores_templates.total_price') }}</th>
                                        <th class="fs-16 fw-medium text-black text-end"></th>
                                    </tr>
                                </thead>
                                <tbody id="cartItemsCloth">
                                    <!-- Dynamic cart items will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Part - Order Summary -->
                <div class="right-part">
                    <div class="custom-card p-20 h-100 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center gap-10 title">
                            <div class="fs-18 fw-semibold text-black leading-100">
                                {{ __('messages.whatsapp_stores_templates.package_summary') }}
                            </div>
                        </div>

                        <!-- Order Summary Details -->
                        <div id="totalDetails" class="flex-grow-1">
                            <!-- Dynamic total details will be populated here -->
                        </div>

                        <div class="sub-total d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="text-black fw-semibold fs-18 leading-100 mb-1">
                                    {{ __('messages.whatsapp_stores.grand_total') }}
                                </h5>
                            </div>
                            <p class="fs-18 fw-semibold leading-100 text-black" id="grandTotal">
                                0
                            </p>
                        </div>

                        <button
                            class="place-order w-100 fs-16 fw-medium text-center order-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#orderNowModal">
                            {{ __('messages.whatsapp_stores_templates.book_now') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

