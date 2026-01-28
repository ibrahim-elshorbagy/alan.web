@extends('layouts.app')
@section('title')
  {{ __('messages.redirect_links.link_rejected') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="col-12">
        <div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
          <div class="card shadow-lg" style="max-width: 600px; width: 100%;">
            <div class="card-body text-center p-5">
              <div class="mb-4">
                <i class="fas fa-times-circle fa-5x text-danger"></i>
              </div>
              <h2 class="mb-3">{{ __('messages.redirect_links.link_rejected') }}</h2>
              <p class="text-muted mb-4">
                {{ __('messages.redirect_links.link_rejected_description') }}
              </p>
              <div class="p-4  alert-info mb-4">
                <i class="fas fa-info-circle"></i>
                <strong>{{ __('messages.redirect_links.redirect_code') }}:</strong> {{ $uri->uri }}
              </div>
              <div class="d-flex justify-content-center gap-3">
                <a href="mailto:{{ $setting['email'] }}" class="btn btn-primary btn-lg">
                  <i class="fas fa-envelope"></i>
                </a>
                <a href="https://wa.me/{{ $setting['prefix_code'] }}{{ $setting['phone'] }}"
                  class="btn btn-success btn-lg" target="_blank">
                  <i class="fab fa-whatsapp"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
