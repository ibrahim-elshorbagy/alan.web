@extends('layouts.guest_simple')
@section('title')
  {{ __('messages.redirect_links.waiting_for_approval') }}
@endsection
@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-lg">
        <div class="card-body text-center p-5">
          <div class="mb-4">
            <i class="fas fa-clock fa-5x text-info"></i>
          </div>
          <h2 class="mb-3">{{ __('messages.redirect_links.waiting_for_approval') }}</h2>
          <p class="text-muted mb-4">
            {{ __('messages.redirect_links.waiting_for_approval_description') }}
          </p>
          <div class="mb-4">
            @if ($nfc->nfc_image)
              <img src="{{ $nfc->nfc_image }}" alt="{{ $nfc->name }}" class="img-fluid rounded" style="max-height: 250px;">
            @else
              <i class="fas fa-credit-card fa-5x text-primary"></i>
            @endif
          </div>
          <h3 class="mb-3">{{ $nfc->name }}</h3>

          <div class="p-4 alert-info mb-4" dir="ltr">
            <strong>Code:</strong> {{ $uri->uri }}
            <br>
            <strong>Serial No: </strong>{{ str_pad($uri->id, 4, '0', STR_PAD_LEFT) }}
          </div>
          <div class="p-4  alert-warning mb-4">
            <i class="fas fa-exclamation-triangle"></i>
            {{ __('messages.redirect_links.contact_sales_to_enable') }}
          </div>
          
          <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
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
