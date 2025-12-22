@extends('layouts.app')
@section('title')
    {{ __('messages.nfc.order_nfc') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column table-striped">
            @include('flash::message')
            <livewire:nfc-orders-table lazy/>
            @include('nfc.guide_nfc_modal')
        </div>
    </div>
@endsection
