<div class="modal fade common-modal-card" tabindex="-1" role="dialog" id="editSubscriptionModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{__('messages.edit_subscription')}}</h3>
                <button type="button" class="modal-close bg-transparent p-0 border-0" data-bs-dismiss="modal"
                        aria-label="Close">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Menu / Close_MD"> <path id="Vector" d="M18 18L12 12M12 12L6 6M12 12L18 6M12 12L6 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
                    </button>
            </div>
            {{ Form::open(['id' => 'editSubscriptionForm']) }}
            {{ Form::text('id',null,['hidden']) }}
            <div class="modal-body pt-0">
                {{ Form::hidden('id',null,['id'=>'SubscriptionId']) }}
                <div>
                        {{ Form::label('End date',__('messages.subscription.end_date').':', ['class' => 'form-label required']) }}
                        {{ Form::text('end_date', null, ['class' => 'form-control bg-white', 'required', 'id'=>'EndDate', 'autocomplete' =>'off']) }}
                </div>
                <p class="text-danger" id="UnlimitedNote"></p>
            </div>
            <div class="modal-footer pt-0 justify-content-start">
                {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary m-0']) }}
                <button type="button" class="btn discard-btn my-0 ms-5 me-0"
                        data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
