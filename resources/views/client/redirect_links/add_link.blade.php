@extends('layouts.app')
@section('title')
  {{ __('messages.redirect_links.add_redirect_link') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="col-12">
        <div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
          <div class="card shadow-lg" style="max-width: 600px; width: 100%;">
            <div class="card-body text-center p-5">
              <div class="mb-4">
                <i class="fas fa-link fa-5x text-warning"></i>
              </div>
              <h2 class="mb-3">{{ __('messages.redirect_links.no_redirect_link') }}</h2>
              <p class="text-muted mb-4">
                {{ __('messages.redirect_links.please_add_redirect_link_description') }}
              </p>
              <div class="p-4  alert-info mb-4">
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

    </div>
  </div>
@endsection
