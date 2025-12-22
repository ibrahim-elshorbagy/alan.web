@extends('layouts.app')
@section('title')
    {{__('messages.faqs.faqs')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column table-striped">
            @include('layouts.errors')
            <div class="card">
                <div class="card-body d-md-flex">
                    @include('settings.front_cms.front_cms_menu')
                    <div class="w-100">
                        <livewire:front-faqs-table lazy/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('sadmin.faqs.create')
    @include('sadmin.faqs.edit')
    @include('sadmin.faqs.show')
@endsection
