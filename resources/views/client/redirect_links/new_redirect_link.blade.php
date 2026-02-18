@extends('layouts.guest_simple')
@section('title')
{{ __('messages.redirect_links.new_nfc_card_available') }}
@endsection
@section('content')
<div class="row justify-content-center">
  <div class="col-md-8 col-lg-6">
    <div class="card shadow-lg mb-0 mb-md-3">
      <div class="card-body text-center p-3 p-md-5">
        <div class="mb-4">
          @if ($nfc->nfc_image)
          <img src="{{ $nfc->nfc_image }}" alt="{{ $nfc->name }}" class="img-fluid rounded" style="max-height: 250px;">
          @else
          <i class="fas fa-credit-card fa-5x text-primary"></i>
          @endif
        </div>
        <h2 class="mb-3">{{ $nfc->name }}</h2>
        <p class="text-muted mb-2">
          {{ __('messages.redirect_links.new_nfc_card_description') }}
        </p>
        <div class="p-2 p-md-4 alert-info mb-4" dir="ltr">
          <strong>Code:</strong> {{ $uri->uri }}
          <br>
          <strong>Serial No: </strong>{{ str_pad($uri->id, 4, '0', STR_PAD_LEFT) }}
        </div>
        <p class="text-muted mb-2">
          {{ __('messages.new_subscriber') }}
        </p>
        <p class="text-muted mb-2">
          <a href="{{ route('register') }}" class="text-primary">{{ __('messages.register_subscription') }}</a>
        </p>
        <p class="text-muted mb-2">
          {{ __('messages.have_subscription') }}
        </p>
        <p class="text-muted mb-2">
          <a href="{{ route('login') }}" class="text-primary">{{ __('messages.please_login') }}</a>
        </p>

        @if (!empty($assignedUser))
        <hr>
        <div class="text-center">
          <p><strong>{{ __('messages.sold_by') }}</strong> {{ $assignedUser->first_name }}
            {{ $assignedUser->last_name }}</p>
          <p><a href="https://wa.me/{{ $assignedUser->contact }}" class="text-success" target="_blank"><i class="fab fa-whatsapp fa-sm"></i> {{ $assignedUser->contact }}</a></p>
        </div>
        @endif

      </div>
    </div>
  </div>
</div>
@endsection
