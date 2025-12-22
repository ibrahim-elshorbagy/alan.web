<div class="d-flex justify-content-center">
    <a title="{{ __('messages.common.download') }}" class="btn px-1 text-primary fs-3" href="{{ route('sadmin.nfc-card-orders.download', $row->id) }}">
        <i class="fa-solid fa-download"></i>
    </a>
    <a title="{{ __('messages.common.view') }}" class="btn px-1 text-info fs-3" href="{{ route('nfc-card-orders.show', $row->id) }}">
        <i class="fa-solid fa-eye"></i>
    </a>
    <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
        class="btn px-1 text-danger fs-3 nfc-order-delete-btn">
        <i class="fa-solid fa-trash-can"></i>
    </a>
</div>
