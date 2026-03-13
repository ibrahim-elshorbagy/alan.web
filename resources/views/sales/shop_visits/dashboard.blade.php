@extends('layouts.app')
@section('title')
  {{ __('messages.shop_visits.dashboard') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>{{ __('messages.shop_visits.dashboard') }}</h1>
        <a href="{{ route('sales.shop-visits.index') }}" class="btn btn-outline-primary">
          {{ __('messages.shop_visits.title') }}
        </a>
      </div>

      @include('sales.shop_visits.partials.stats_cards', ['stats' => $stats])
      @include('sales.shop_visits.partials.stats_charts', ['stats' => $stats])

    </div>
  </div>
@endsection