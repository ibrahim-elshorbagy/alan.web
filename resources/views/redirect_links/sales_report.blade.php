@extends('layouts.app')
@section('title')
  {{ __('messages.redirect_links.sales_report') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <ul class="nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap" role="tablist">
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link p-0" href="{{ route('redirect-links.index') }}">
            {{ __('messages.redirect_links.title') }}
          </a>
        </li>
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link p-0" href="{{ route('redirect-links.history-report') }}">
            {{ __('messages.redirect_links.history_report') }}
          </a>
        </li>
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link active p-0" href="{{ route('redirect-links.sales-report') }}">
            {{ __('messages.redirect_links.sales_report') }}
          </a>
        </li>
      </ul>
      <livewire:redirect-links-sales-report />
    </div>
  </div>
@endsection