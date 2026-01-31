@extends('layouts.guest_simple')
@section('title')
  {{ __('messages.redirect_links.card_not_received') }}
@endsection
@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-lg">
        <div class="card-body text-center p-5">
          <div class="mb-4">
            <i class="fas fa-truck fa-5x text-secondary"></i>
          </div>
          <h2 class="mb-3">{{ __('messages.redirect_links.card_not_received') }}</h2>
          <p class="text-muted mb-4">
            {{ __('messages.redirect_links.card_not_received_description') }}
          </p>
          <div class="p-4  alert-info mb-4">
            <i class="fas fa-info-circle"></i>
            <strong>{{ __('messages.redirect_links.redirect_code') }}:</strong> {{ $uri->uri }}
          </div>
          <div class="d-flex justify-content-center gap-3">
            @if (!empty($isAuth) && $isAuth)
              <a href="mailto:{{ $setting['email'] }}" class="btn btn-primary btn-lg">
                <i class="fas fa-envelope"></i>
              </a>
              <a href="https://wa.me/{{ $setting['prefix_code'] }}{{ $setting['phone'] }}" class="btn btn-success btn-lg"
                target="_blank">
                <i class="fab fa-whatsapp"></i>
              </a>
            @else
              <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-sign-in-alt"></i> {{ __('messages.common.login') }}
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>
  @endsection
