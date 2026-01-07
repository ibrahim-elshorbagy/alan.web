@extends('layouts.app')
@section('title')
  {{ __('messages.redirect_links.title') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column table-striped">
      @include('flash::message')

      {{-- Manual flash message for download success --}}
      @if(request()->get('success') == '1')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ __('messages.redirect_links.created') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <livewire:redirect-links-table />
    </div>
  </div>
@endsection
