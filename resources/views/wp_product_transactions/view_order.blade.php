<div class="modal fade" id="wpStoreShowProductOrderModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{ __('messages.whatsapp_stores.order_details') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.whatsapp_stores.order_id') . ':' }}
                        </label>
                        <p id="orderId" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.common.name') . ':' }}
                        </label>
                        <p id="orderName" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.common.phone') . ':' }}
                        </label>
                        <p id="orderPhone" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.common.status') . ':' }}
                        </label>
                        <p id="orderStatus" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div class="col-sm-12 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.setting.address') }}:
                        </label>
                        <div id="orderAddress" class="d-flex flex-wrap"></div>
                    </div>
                </div>
                <h3>{{ __('messages.whatsapp_stores.order_items') }}</h3>
                <div class="mt-2 table-responsive table-striped overflow-auto">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('messages.vcard.product_name') }}</th>
                                <th>{{ __('messages.common.price') }}</th>
                                <th>{{ __('messages.whatsapp_stores_templates.quantity') }}</th>
                                <th>{{ __('messages.whatsapp_stores_templates.total_price') }}</th>
                            </tr>
                        </thead>
                        <tbody class="product-list"></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end">{{ __('messages.whatsapp_stores.grand_total') }}:</td>
                                <td id="orderGrandTotal" class="fw-bold"></td>

                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
