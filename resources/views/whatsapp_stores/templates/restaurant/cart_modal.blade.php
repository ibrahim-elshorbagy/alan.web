<div class="modal fade restaurant-add-cart-modal" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <div class="row row-gap-30px mx-0">
                    <div class="col-lg-8">
                        <div class="recommended-section overflow-auto h-100">

                            <div class="recommended">
                                <table class="w-100">
                                    <thead>
                                        <tr>
                                            <th class="fs-18 fw-5 text-white">
                                                {{ __('messages.whatsapp_stores.products') }}</th>
                                            <th class="fs-18 fw-5 text-white text-center text-nowrap">
                                                {{ __('messages.whatsapp_stores_templates.quantity') }}</th>
                                            <th class="fs-18 fw-5 text-white text-center text-nowrap">
                                                {{ __('messages.whatsapp_stores_templates.total_price') }}</th>
                                            <th class="fs-18 fw-5 text-white text-end"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="cartItemsCloth">

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart-section d-flex justify-content-between flex-column h-100">
                            <div class="mb-20">
                                <div class="cart-box">
                                    <h2 class="fs-20 fw-5 text-white mb-0">
                                        {{ __('messages.whatsapp_stores_templates.total_price') }}</h2>
                                    <div id="totalDetails">

                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="fs-20 text-white text-end fw-5 mb-0 py-3 total">
                                    {{ __('messages.whatsapp_stores.grand_total') }} : <span id="grandTotal">0</span>
                                </p>
                                <button class="btn btn-primary w-100 order-btn" data-bs-toggle="modal" data-bs-target="#orderNowModal">
                                    {{ __('messages.whatsapp_stores_templates.order_now') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
