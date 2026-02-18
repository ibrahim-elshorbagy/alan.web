@extends('layouts.guest_simple')
@section('title')
{{ __('messages.redirect_links.link_rejected') }}
@endsection
@section('content')
<div class="row justify-content-center">
  <div class="col-md-8 col-lg-6">
    <div class="card shadow-lg mb-0 mb-md-3">
      <div class="card-body text-center p-3 p-md-5">
        <div class="mb-4">
          <i class="fas fa-times-circle fa-5x text-danger"></i>
        </div>
        <h2 class="mb-3">{{ __('messages.redirect_links.link_rejected') }}</h2>
        <p class="text-muted mb-2">
          {{ __('messages.redirect_links.link_rejected_description') }}
        </p>
        <div class="p-2 p-md-4 alert-info mb-4">
          <i class="fas fa-info-circle"></i>
          <strong>{{ __('messages.redirect_links.redirect_code') }}:</strong> {{ $uri->uri }}
        </div>
        <div class="d-flex justify-content-center gap-3">
          <i class="fas fa-envelope"></i>
          </a>
          <a href="https://wa.me/{{ $setting['prefix_code'] }}{{ $setting['phone'] }}" class="btn btn-success btn-lg" target="_blank">
            <i class="fab fa-whatsapp"></i>
          </a>

        </div>

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
  @endsection
