@extends('layouts.app')
@section('title')
    {{ __('messages.whatsapp_stores.whatsapp_stores') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column table-striped">
            @include('flash::message')
            <livewire:whatsapp-store-table lazy />
        </div>
    </div>
@endsection
