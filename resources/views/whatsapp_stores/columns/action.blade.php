<div class="justify-content-center d-flex gap-3 align-items-center">
    @if (analyticsFeature())
<a href="{{ route('whatsapp.store.analytics', $row->id)}}" class="text-primary" >
    <i class="fa-solid fa-chart-line fs-2"></i>
</a>
@endif
<a href="{{ route('whatsapp.store.showSubscribers', $row->id)}}" class="text-primary" >
    <h3 class="d-flex align-items-center justify-content-start mb-0"><i class="fa-solid fa-users"></i></h3>
 </a>

    <a href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $row->id, 'part' => 'basics']) }}" class="btn px-1 text-primary  fs-3"
        title="{{ __('messages.common.edit') }}">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>

    <a href="javascript:void(0)" title="<?php echo __('messages.common.delete'); ?>" data-id="{{ $row->id }}"
        class="whatsapp-store-delete-btn btn px-1 text-danger fs-3" data-turbo="false">
        <i class="fa-solid fa-trash-can"></i>
    </a>
</div>
