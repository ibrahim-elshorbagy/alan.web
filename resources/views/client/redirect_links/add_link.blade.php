@extends('layouts.guest_simple')
@section('title')
  {{ __('messages.redirect_links.add_redirect_link') }}
@endsection
@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-lg mb-0 mb-md-3">
        <div class="card-body text-center p-3 p-md-5">
          <div class="mb-4">
            <i class="fas fa-link fa-5x text-warning"></i>
          </div>
          <h2 class="mb-3">{{ __('messages.redirect_links.no_redirect_link') }}</h2>
          <p class="text-muted mb-2">
            {{ __('messages.redirect_links.please_add_redirect_link_description') }}
          </p>
          <div class="p-2 p-md-4 alert-info mb-4">
            <i class="fas fa-info-circle"></i>
            <strong>{{ __('messages.redirect_links.redirect_code') }}:</strong> {{ $uri->uri }}
          </div>
          <a href="{{ route('client.redirect-links.edit', $uri->id) }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i> {{ __('messages.redirect_links.add_redirect_link') }}
          </a>

        </div>
      </div>
    </div>
  </div>
@endsection
