@extends('layouts.app')
@section('title')
  {{ __('messages.redirect_links.title') }}
@endsection
@section('content')
  <div class="container-fluid">
    <style>
      .table-responsive .table th,
      .table-responsive .table td {
        font-size: 0.875rem;
        padding: 0.5rem;
      }

      .table-responsive {
        font-size: 0.875rem;
      }
    </style>
    <div class="d-flex flex-column table-striped">
      <ul class="nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap" role="tablist">
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link active p-0" href="{{ route('redirect-links.index') }}">
            {{ __('messages.redirect_links.title') }}
          </a>
        </li>
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link p-0" href="{{ route('redirect-links.history-report') }}">
            {{ __('messages.redirect_links.history_report') }}
          </a>
        </li>
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link p-0" href="{{ route('redirect-links.sales-report') }}">
            {{ __('messages.redirect_links.sales_report') }}
          </a>
        </li>
      </ul>
      @livewire('redirect-links-custom-table')
    </div>
  </div>
@endsection
@section('scripts')
  <script>
    document.addEventListener('livewire:updated', function () {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
    });
  </script>
@endsection