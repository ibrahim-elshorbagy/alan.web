@extends('layouts.app')
@section('title')
    {{__('Subscriber')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mb-5 d-inline-block">{{ __('messages.whatsapp_stores.email_subscription') }}</h1>
            <a href="{{ route('whatsapp.stores') }}" class="btn btn-outline-primary">
                {{ __('messages.common.back') }}
            </a>
        </div>

        <div class="d-flex flex-column table-striped">
            @include('flash::message')
            <livewire:WhatsappStoreSubscriber lazy :whatsappStoreId="$whatsappStoreId"/>
        </div>
    </div>
@endsection
