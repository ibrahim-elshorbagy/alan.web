<div class="modal fade" id="addCustomLinkModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{ __('messages.vcard.new_custom_link') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['id' => 'addCustomLinkForm']) !!}
            <div class="modal-body">
                <div class="row mb-5">
                    {{ Form::hidden('vcard_id', $vcard->id) }}
                    <input type="hidden" name="part" value="{{ $partName }}">
                    <div class="col-6">
                        {{ Form::label('link_name', __('messages.custom_links.link_name') . ':', ['class' => 'form-label required']) }}
                        {{ Form::text('link_name', null, ['class' => 'form-control form-control-color w-100 mb-7', 'required', 'placeholder' => __('messages.custom_links.link_name'), 'id' => 'link_name']) }}
                    </div>
                    <div class="col-6">
                        {{ Form::label('link', __('messages.custom_links.link') . ':', ['class' => 'form-label required']) }}
                        {{ Form::text('link', null, ['class' => 'form-control form-control-color w-100 mb-7', 'required', 'placeholder' => __('messages.custom_links.link'), 'id' => 'link']) }}
                    </div>
                    <div class="col-6">
                        {{ Form::label('button_color Color', __('messages.custom_links.button_color') . ':', ['class' => 'form-label']) }}
                        {{ Form::color('button_color', '#6571ff', ['class' => 'form-control form-control-color w-100 mb-7 mx-md-0 mx-auto', 'id' => 'button_color']) }}
                    </div>
                    <div class="col-6">
                        <label for="buttonType" class="form-label">{{ __('messages.custom_links.button_type') }}</label>
                        @php
                            $customLinksBtn = collect(App\Models\CustomLink::BUTTON_STYLE)->map(function ($value) {
                                return trans('messages.custom_link.' . $value);
                            });
                        @endphp
                        {{ Form::select('button_type', $customLinksBtn, null, ['class' => 'form-control form-select', 'data-control' => 'select2', 'id' => 'buttonType']) }}
                    </div>
                    <div class="col-lg-6 mb-7">
                        <div class="d-flex">
                            {{ Form::label('show_as_button', __('messages.custom_links.show_as_button') . ':', ['class' => 'form-label']) }}
                            <div class="mx-4">
                                <div
                                    class="form-check form-switch form-check-custom form-check-solid form-switch-sm col-6">
                                    <div class="fv-row d-flex align-items-center">
                                        {{ Form::checkbox('show_as_button', 1, 0, ['class' => 'form-check-input mt-0 ', 'id' => 'ShowAsButton']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-7">
                        <div class="d-flex">
                            {{ Form::label('show_as_button', __('messages.custom_links.open_in_new_tab') . ':', ['class' => 'form-label']) }}
                            <div class="mx-4">
                                <div
                                    class="form-check form-switch form-check-custom form-check-solid form-switch-sm col-6">
                                    <div class="fv-row d-flex align-items-center">
                                        {{ Form::checkbox('open_new_tab', 1, 0, ['class' => 'form-check-input mt-0 ', 'id' => 'OpenNewTab']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['class' => 'btn btn-primary m-0', 'id' => 'customLinkSave', 'type' => 'submit']) }}
                {{ Form::button(__('messages.common.discard'), ['class' => 'btn btn-secondary my-0 ms-5 me-0', 'data-bs-dismiss' => 'modal']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
