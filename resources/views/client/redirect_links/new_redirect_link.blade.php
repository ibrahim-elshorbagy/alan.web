@extends('layouts.guest_simple')
@section('title')
  {{ __('messages.redirect_links.new_nfc_card_available') }}
@endsection
@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-lg">
        <div class="card-body text-center p-5">
          <div class="mb-4">
            @if ($nfc->nfc_image)
              <img src="{{ $nfc->nfc_image }}" alt="{{ $nfc->name }}" class="img-fluid rounded" style="max-height: 250px;">
            @else
              <i class="fas fa-credit-card fa-5x text-primary"></i>
            @endif
          </div>
          <h2 class="mb-3">{{ $nfc->name }}</h2>
          <p class="text-muted mb-4">
            {{ __('messages.redirect_links.new_nfc_card_description') }}
          </p>
          <div class="p-4 alert-info mb-4">
            <strong>{{ __('messages.redirect_links.redirect_code') }}:</strong> {{ $uri->uri }}
            <br>
            <strong>Serial No: </strong>{{ str_pad($uri->uri, 4, '0', STR_PAD_LEFT) }}
          </div>
          <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
              <i class="fas fa-user-plus"></i> {{ __('messages.common.register') }}
            </a>
            <a href="{{ route('login') }}" class="btn btn-success btn-lg">
              <i class="fas fa-sign-in-alt"></i> {{ __('messages.common.login') }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
