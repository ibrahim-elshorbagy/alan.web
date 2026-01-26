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
      @livewire('redirect-links-custom-table')
    </div>
  </div>
@endsection
@section('scripts')
  <script>
    document.addEventListener('livewire:updated', function() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
    });
  </script>
@endsection
