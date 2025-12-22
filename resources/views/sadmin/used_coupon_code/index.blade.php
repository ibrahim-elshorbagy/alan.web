@extends('layouts.app')
@section('title')
    {{ __('messages.coupon_code.used_coupon_codes') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column table-striped">
            @include('flash::message')
            <livewire:used-coupon-code-table lazy />
        </div>
    </div>
@endsection
