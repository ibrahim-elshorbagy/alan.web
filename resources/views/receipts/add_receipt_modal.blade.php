<div class="modal fade common-modal-card" id="addReceiptModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">{{ __('messages.receipts.add_receipt') }}</h3>
        <button type="button" class="modal-close p-0 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close">
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
      {{ Form::open(['id' => 'addReceiptForm']) }}
      <div class="modal-body pt-0">
        <div class="alert alert-danger fs-4 text-white d-flex align-items-center d-none" role="alert"
          id="ReceiptValidationErrorsBox">
          <i class="fa-solid fa-face-frown me-5"></i>
        </div>

        <input type="hidden" name="user_id" id="addUserId">

        <div class="mb-3">
          {{ Form::label('amount', __('messages.receipts.amount') . ':', ['class' => 'form-label required']) }}
          {{ Form::number('amount', null, ['class' => 'form-control', 'required', 'step' => '0.01', 'min' => '0', 'placeholder' => __('messages.receipts.amount')]) }}
        </div>

        <div class="mb-3">
          {{ Form::label('received_at', __('messages.receipts.received_at') . ':', ['class' => 'form-label required']) }}
          {{ Form::date('received_at', date('Y-m-d'), ['class' => 'form-control', 'required']) }}
        </div>

        <div class="mb-3">
          {{ Form::label('description', __('messages.receipts.description') . ':', ['class' => 'form-label']) }}
          {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3', 'placeholder' => __('messages.receipts.description')]) }}
        </div>
      </div>
      <div class="modal-footer pt-0 justify-content-start">
        {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'btn btn-primary m-0', 'id' => 'btnSave']) }}
        <button type="button" class="btn discard-btn my-0 ms-3 me-0"
          data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
