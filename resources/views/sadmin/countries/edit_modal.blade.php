<div class="modal fade common-modal-card" id="editCountryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.country.edit_country') }}</h3>
                <button type="button" class="modal-close bg-transparent p-0 border-0" data-bs-dismiss="modal"
                        aria-label="Close">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Menu / Close_MD"> <path id="Vector" d="M18 18L12 12M12 12L6 6M12 12L18 6M12 12L6 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
                    </button>
            </div>
            {{ Form::open(['id' => 'editCountryForm']) }}
            <div class="modal-body pt-0">
                {{ Form::hidden('countryId',null,['id'=>'countryId']) }}
                    <div class="mb-5">
                        {{ Form::label('name',__('messages.common.name').':', ['class' => 'form-label required']) }}
                        {{ Form::text('name', null, ['class' => 'form-control', 'required', 'id'=>'editName']) }}
                    </div>
                <div class="mb-3">
                        {{ Form::label('short_code',__('messages.country.short_code').':', ['class' => 'form-label required']) }}
                        {{ Form::text('short_code', null, ['class' => 'form-control','maxlength' => '2' , 'required', 'onkeypress' => 'return (event.charCode > 64 && event.charCode < 91 ) || (event.charCode > 96 && event.charCode < 123)', 'id' => 'editShortCode']) }}
                    </div>
                <div>
                        {{ Form::label('phone_code',__('messages.country.phone_code').':', ['class' => 'form-label']) }}
                        {{ Form::text('phone_code', null, ['class' => 'form-control', 'maxlength' => '4', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'id'=>'editPhoneCode']) }}
                    </div>

            </div>
            <div class="modal-footer pt-0 justify-content-start">
                {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary m-0']) }}
                <button type="button" class="btn my-0 ms-3 discard-btn me-0"
                        data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
