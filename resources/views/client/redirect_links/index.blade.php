@extends('layouts.app')
@section('title')
  {{ __('messages.redirect_links.title') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column table-striped">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ __('messages.redirect_links.my_redirect_links') }}</h1>
        <div class="d-flex gap-2">
          <a href="{{ route('client.redirect-links.export-all-my-contests') }}" class="btn  btn-outline-primary">
            <i class="fa-solid fa-file-excel"></i> {{ __('messages.contest.export_all_contests') }}
          </a>
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#redeemModal">
            <i class="fas fa-gift"></i> {{ __('messages.redirect_links.redeem_code') }}
          </button>
        </div>
      </div>
      @include('flash::message')
      <div class="table-responsive">
        <livewire:client-redirect-links-table lazy />
      </div>
    </div>
  </div>

  <!-- Redeem Modal -->
  <div class="modal fade" id="redeemModal" tabindex="-1" aria-labelledby="redeemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="redeemModalLabel">{{ __('messages.redirect_links.redeem_code') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('client.redirect-links.redeem') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="Code" class="form-label required">{{ __('messages.redirect_links.enter_redeem_code') }}</label>
              <input type="text" class="form-control" id="uri" name="uri" required
                placeholder="{{ __('messages.redirect_links.redeem_code_placeholder') }}"
                value="{{ session('pending_redeem_uri') }}">
              <small class="text-muted">{{ __('messages.redirect_links.redeem_code_hint') }}</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
              data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            <button type="submit" class="btn btn-success">{{ __('messages.redirect_links.redeem') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      @if (session('pending_redeem_uri'))
        // Auto-open the redeem modal if there's a pending URI in session
        var redeemModal = new bootstrap.Modal(document.getElementById('redeemModal'));
        redeemModal.show();
      @endif
      });
  </script>
@endpush