@extends('layouts.app')
@section('title')
  {{ __('messages.shop_visits.dashboard') }} - {{ $salesUser->first_name }} {{ $salesUser->last_name }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>{{ __('messages.shop_visits.dashboard') }} - {{ $salesUser->first_name }} {{ $salesUser->last_name }}</h1>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.sales-visits.index', $salesUser->id) }}" class="btn btn-outline-primary">
            {{ __('messages.shop_visits.title') }}
          </a>
          <a href="{{ route('admins.index') }}" class="btn btn-outline-secondary">{{ __('messages.common.back') }}</a>
        </div>
      </div>

      @include('sales.shop_visits.partials.stats_cards', ['stats' => $stats])
      @include('sales.shop_visits.partials.stats_charts', ['stats' => $stats])

    </div>
  </div>
@endsection