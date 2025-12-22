<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">

            <div class="modal-body p-0 border-0">
                <div class="row overflow-auto">
                    <div class="col-12 col-lg-8 mb-4 mb-lg-0">
                        <div class="table-details overflow-auto h-100">
                            <table class="w-100">
                                <thead>
                                    <tr>
                                        <th class="fs-18 fw-5 text-black">{{ __('messages.whatsapp_stores.products') }}</th>
                                        <th class="fs-18 fw-5 text-black text-center text-nowrap"> {{ __('messages.whatsapp_stores_templates.quantity') }}</th>
                                        <th class="fs-18 fw-5 text-black text-center text-nowrap">  {{ __('messages.whatsapp_stores_templates.total_price') }}</th>
                                        <th class="fs-18 fw-5 text-black text-end"></th>
                                    </tr>
                                </thead>
                                <tbody id="cartItemsCloth">
                                 
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="table-details d-flex flex-column h-100 justify-content-between">
                            <h2 class="fs-20 fw-5 text-black mb-0">{{ __('messages.whatsapp_stores_templates.total_price') }}</h2>
                            <div id="totalDetails" class="flex-grow-1">

                            </div>
                            <div class="mb-15">
                                <p class="fs-20 text-black text-end fw-5 mb-0 py-3 total" >{{ __('messages.whatsapp_stores.grand_total') }} : <span id="grandTotal">0</span> </p>
                                <button class="btn btn-primary w-100 fs-18 fw-5 order-btn" data-bs-toggle="modal" data-bs-target="#orderNowModal">
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
