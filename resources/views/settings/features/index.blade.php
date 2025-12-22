@extends('layouts.app')
@section('title')
    {{__('messages.plan.features')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column table-striped">
            @include('flash::message')
            <div class="card">
                <div class="card-body d-md-flex">
                    @include('settings.front_cms.front_cms_menu')
                    <div>
                        <livewire:feature-table lazy/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
