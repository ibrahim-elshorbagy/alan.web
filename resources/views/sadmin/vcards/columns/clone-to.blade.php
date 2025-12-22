<div>
    <div class="justify-content-start d-flex">
        <a title="{{ __('messages.vcard.clone_to') }}" data-id="{{ $row->id }}"
            class="btn btn-primary vcard-clone py-1 px-2">
            {{ __('messages.vcard.clone_to') }}
        </a>
    </div>
    @include('sadmin.vcards.vcard-clone-modal')
</div>
