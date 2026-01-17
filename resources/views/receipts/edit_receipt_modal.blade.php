<div class="modal fade common-modal-card" id="editReceiptModal" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">{{ __('messages.receipts.edit_receipt') }}</h2>
        <button type="button" class="modal-close bg-transparent p-0 border-0" data-bs-dismiss="modal"
          aria-label="Close">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
              <path d="M6 18L18 6M6 6l12 12" stroke="#6B7280" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round"></path>
            </g>
          </svg>
        </button>
      </div>
      <div class="modal-body pt-0">
        {!! Form::open(['id' => 'editReceiptForm']) !!}
        <div class="row">
          {{ Form::hidden('receipt_id', null, ['id' => 'receiptId']) }}
          {{ Form::hidden('user_id', null, ['id' => 'editUserId']) }}

          <div class="col-sm-12 mb-3">
            {{ Form::label('amount', __('messages.receipts.amount') . ':', ['class' => 'form-label required']) }}
            {{ Form::number('amount', null, ['class' => 'form-control', 'id' => 'editAmount', 'required', 'step' => '0.01', 'min' => '0', 'placeholder' => __('messages.receipts.amount')]) }}
          </div>

          <div class="col-sm-12 mb-3">
            {{ Form::label('received_at', __('messages.receipts.received_at') . ':', ['class' => 'form-label required']) }}
            {{ Form::date('received_at', null, ['class' => 'form-control', 'id' => 'editReceivedAt', 'required']) }}
          </div>

          <div class="col-sm-12 mb-3">
            {{ Form::label('description', __('messages.receipts.description') . ':', ['class' => 'form-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'id' => 'editDescription', 'rows' => '3', 'placeholder' => __('messages.receipts.description')]) }}
          </div>

          <div class="d-flex justify-content-start modal-footer p-0">
            {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'btn btn-primary m-0']) }}
            <button type="button" class="btn discard-btn my-0 ms-3 me-0"
              data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
