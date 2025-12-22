<div>
    <div class="justify-content-center d-flex">
        <a href="{{ route('sadmin.vcard.analytics', $row->id) }}" class="text-primary ps-0 pe-2 py-1 @if(getCurrentLanguageName() == 'ar' || getCurrentLanguageName() == 'fa') me-2 @endif">
            <i class="fa-solid fa-chart-line fs-2"></i>
        </a>
        <a title="{{ __('messages.vcard.clone_to') }}" data-id="{{ $row->id }}"
            class="btn btn-primary vcard-clone py-1 px-2">
            <i class="fa-solid fa-clone"></i>
        </a>
        @include('sadmin.vcards.vcard-clone-modal')
    </div>
</div>
