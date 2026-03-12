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
      <div class="row g-4 mb-5">
        {{-- Daily --}}
        <div class="col-lg-4">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
              <div class="mb-2">
                <i class="fas fa-calendar-day fa-2x text-primary"></i>
              </div>
              <h5 class="card-title">{{ __('messages.shop_visits.daily_stats') }}</h5>
              <div class="d-flex justify-content-around mt-3">
                <div>
                  <h3 class="fw-bold text-primary mb-0">{{ $stats['daily_visits'] }}</h3>
                  <small class="text-muted">{{ __('messages.shop_visits.visits') }}</small>
                </div>
                <div>
                  <h3 class="fw-bold text-success mb-0">{{ $stats['daily_cards'] }}</h3>
                  <small class="text-muted">{{ __('messages.shop_visits.cards_sold') }}</small>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Weekly --}}
        <div class="col-lg-4">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
              <div class="mb-2">
                <i class="fas fa-calendar-week fa-2x text-info"></i>
              </div>
              <h5 class="card-title">{{ __('messages.shop_visits.weekly_stats') }}</h5>
              <div class="d-flex justify-content-around mt-3">
                <div>
                  <h3 class="fw-bold text-info mb-0">{{ $stats['weekly_visits'] }}</h3>
                  <small class="text-muted">{{ __('messages.shop_visits.visits') }}</small>
                </div>
                <div>
                  <h3 class="fw-bold text-success mb-0">{{ $stats['weekly_cards'] }}</h3>
                  <small class="text-muted">{{ __('messages.shop_visits.cards_sold') }}</small>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Monthly --}}
        <div class="col-lg-4">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
              <div class="mb-2">
                <i class="fas fa-calendar-alt fa-2x text-warning"></i>
              </div>
              <h5 class="card-title">{{ __('messages.shop_visits.monthly_stats') }}</h5>
              <div class="d-flex justify-content-around mt-3">
                <div>
                  <h3 class="fw-bold text-warning mb-0">{{ $stats['monthly_visits'] }}</h3>
                  <small class="text-muted">{{ __('messages.shop_visits.visits') }}</small>
                </div>
                <div>
                  <h3 class="fw-bold text-success mb-0">{{ $stats['monthly_cards'] }}</h3>
                  <small class="text-muted">{{ __('messages.shop_visits.cards_sold') }}</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection