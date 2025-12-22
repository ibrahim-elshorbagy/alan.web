@extends('layouts.app')
@section('title')
    {{ __('messages.nfc.nfc_card_orders') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column table-striped sell-nfc-card-order">
            @include('flash::message')
            <livewire:nfc-card-order-table lazy />
        </div>
    </div>
@endsection
