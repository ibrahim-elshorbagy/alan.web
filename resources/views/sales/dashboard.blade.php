@extends('layouts.app')
@section('title')
  {{ __('messages.dashboard') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>{{ __('messages.dashboard') }}</h1>
      </div>

      {{-- Shop Visits Stats --}}
      <h5 class="mb-3">{{ __('messages.shop_visits.title') }}</h5>
      <div class="mb-5">
        @include('sales.shop_visits.partials.stats_cards', ['stats' => $stats])
        @include('sales.shop_visits.partials.stats_charts', ['stats' => $stats])
      </div>

    </div>
  </div>
@endsection