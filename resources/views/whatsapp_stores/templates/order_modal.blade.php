 <div class="modal fade" @if (getLanguage($whatsappStore->default_language) == 'Arabic' || getLanguage($whatsappStore->default_language) == 'Persian') dir="rtl" @endif id="orderNowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered order-modal-dialog">
         <div class="modal-content" @if (getLanguage($whatsappStore->default_language) == 'Arabic' || getLanguage($whatsappStore->default_language) == 'Persian') dir="rtl" @endif>
             <div class="modal-header px-0 pt-0">
                 <input type="hidden" value="{{ $whatsappStore->id }}" id="whatsappStoreId">
                 @if ($whatsappStore->template_id != 8)
                     <h5 class="modal-title fs-20 fw-6" id="exampleModalLabel">
                         {{ __('messages.whatsapp_stores.order_details') }}
                     </h5>
                 @else
                     <h5 class="modal-title fs-20 fw-6" id="exampleModalLabel">
                         {{ __('messages.whatsapp_stores.package_details') }}
                     </h5>
                 @endif
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body pb-0">
                 <div>
                     <form id="orderForm">
                         <div class="row">
                             <div class="col-sm-12">
                                 <div class="mb-3 form-group">
                                     <label for="name" class="form-label">{{ __('messages.common.name') }}:
                                     </label><span class="text-danger">*</span>
                                     <input type="text" required class="form-control" name="name" id="name"
                                         placeholder="{{ __('messages.common.name') }}">
                                     <input type="hidden" name="baseUrl" id="baseUrl"
                                         value="{{ config('app.url') }}">
                                     <input type="hidden" id="storeAlias" name="url_alias"
                                         value="{{ $whatsappStore->url_alias }}">
                                     <input type="hidden" id="wpRegionCode" value="{{ $whatsappStore->region_code }}">
                                     <input type="hidden" id="whatsappNo" value="{{ $whatsappStore->whatsapp_no }}">
                                     <input type="hidden" id="productBuyUrl"
                                         value="{{ url(route('whatsapp.store.product.buy')) }}">
                                 </div>
                             </div>
                             <div class="col-sm-12">
                                 <div class="form-group mb-3 phone-block {{ app()->getLocale() == 'ar' || app()->getLocale() == 'fa' ? 'rtl-phone-input' : '' }}">
                                     <label for="phoneNumber" class="form-label required">
                                         {{ __('messages.whatsapp_stores.whatsapp_no') }}:
                                     </label><span class="text-danger">*</span>
                                     <input type="text" required name="phone" id="phoneNumber" class="form-control "
                                         placeholder="{{ __('messages.whatsapp_stores.whatsapp_no') }}"
                                         onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" />

                                     <input type="hidden" name="region_code" value="{{ $whatsappStore->region_code }}"
                                         id="prefix_code" />
                                 </div>
                             </div>
                             <div class="col-sm-12">
                                 <div class="mb-3 form-group">
                                     <label for="name" class="form-label">{{ __('messages.setting.address') }}:
                                     </label><span class="text-danger">*</span>
                                     <textarea class="form-control" id="address" name="address" rows="3" required
                                         placeholder="{{ __('messages.setting.address') }}"></textarea>
                                 </div>
                             </div>
                         </div>

                         @if ($whatsappStore->template_id != 8)
                             <button type="submit" class="btn btn-primary m-0 w-100">
                                    {{ __('messages.whatsapp_stores_templates.order_now') }}
                             </button>
                         @else
                             <button type="submit" class="btn btn-primary m-0 w-100">
                                    {{ __('messages.whatsapp_stores_templates.book_now') }}
                             </button>
                         @endif
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>
