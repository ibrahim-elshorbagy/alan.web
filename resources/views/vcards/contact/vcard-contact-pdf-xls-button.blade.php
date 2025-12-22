@php
    $contactsCount = App\Models\ContactRequest::where('vcard_id', $this->vcardId)->count();
@endphp
<div class="d-flex justify-content-end mb-3">
    <div>
        <a href="{{ route('vcards.contacts.download.pdf', $this->vcardId) }}" target="_blank" class="btn btn-danger @if($contactsCount == 0) disabled @endif">
            <i class="fa fa-file-pdf"></i> {{ __('messages.vcard.export_pdf') }}
        </a>
    </div>
    <div class="ms-2">
        <a href="{{ route('vcards.contacts.download.xls', $this->vcardId) }}" target="_blank" class="btn btn-success me-2 @if($contactsCount == 0) disabled @endif">
            <i class="fa fa-file-excel"></i> {{ __('messages.vcard.export_xls') }}
        </a>
    </div>
</div>
