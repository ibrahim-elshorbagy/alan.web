@extends('settings.edit')
@section('section')
    <div class="card w-100">
        <div class="card-body d-flex flex-column flex-md-row gap-3">
            @include('settings.setting_menu')
            <div class="w-100 overflow-auto">
                <livewire:custom-domain-data-table />
            </div>
        </div>
    </div>
    @include('settings.custom_domain_reject_modal')
@endsection
