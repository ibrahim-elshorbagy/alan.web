<div class="overflow-auto">
    <div class="table-striped w-100">
        <livewire:vcard-custom-link-table lazy :vcard-id="$vcard->id"/>
    </div>
    </div>
    @include('vcards.custom-link.create')
    @include('vcards.custom-link.edit')

