@extends('layouts.app')
@section('title')
    {{__('messages.custom_page.custom_page')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column table-striped">
            @include('flash::message')
            <livewire:custom-page />
        </div>
    </div>
@endsection
