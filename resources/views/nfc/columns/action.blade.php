<div class="d-flex justify-content-center">
    <a title="{{ __('messages.common.download') }}" class="btn px-1 text-warning fs-3" href="{{ route('nfc-card-orders.download', $row->id) }}">
        <i class="fa-solid fa-download"></i>
    </a>
    <a title="{{ __('messages.common.view') }}" class="btn px-1 text-info fs-3" href="{{ route('my-nfc-orders.show', $row->id) }}">
        <i class="fa-solid fa-eye"></i>
    </a>
</div>
