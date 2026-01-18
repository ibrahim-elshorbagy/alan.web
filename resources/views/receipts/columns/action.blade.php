<div>
  <div class="d-flex justify-content-center">
    <a href="{{ route('receipts.single.pdf', $row->id) }}" target="_blank" class="btn px-1 text-primary fs-3"
      data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.common.print') }}">
      <i class="fa-solid fa-print"></i>
    </a>
    <a href="javascript:void(0)" data-id="{{ $row->id }}" class="btn px-1 text-info fs-3 receipt-edit-btn"
      data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.common.edit') }}">
      <i class="fa-solid fa-pen-to-square"></i>
    </a>
    <a href="javascript:void(0)" data-id="{{ $row->id }}" class="btn px-1 text-danger fs-3 receipt-delete-btn"
      data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.common.delete') }}">
      <i class="fa-solid fa-trash"></i>
    </a>
  </div>
</div>
