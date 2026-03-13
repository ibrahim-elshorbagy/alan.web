<div class="row g-4">
  <div class="col-12">
    <h6 class="text-muted fw-semibold mb-3 text-uppercase" style="font-size:.75rem;letter-spacing:.08em;">
      <i class="fas fa-layer-group me-1"></i>{{ __('messages.shop_visits.dashboard') }}
    </h6>
  </div>

  {{-- 1) All-time --}}
  <div class="col-xl col-lg-4 col-md-6">
    <div class="card border-0 shadow-sm h-100" style="border-top:4px solid #3F51B5 !important;">
      <div class="card-body text-center">
        <div class="mb-2">
          <i class="fas fa-calendar-alt fa-2x" style="color:#3F51B5;"></i>
        </div>
        <h5 class="card-title"> {{ __('messages.shop_visits.all_time_stats') }}</h5>
        <div class="fw-bold" style="font-size:1.2rem;color:#1f2937;">{{ $stats['total_visits'] }}
          {{ __('messages.shop_visits.visits') }}</div>
        <div class="fw-semibold" style="font-size:1.05rem;color:#3F51B5;">{{ $stats['total_active_sales'] }}
          {{ __('messages.shop_visits.active_cards') }}</div>
      </div>
    </div>
  </div>

  {{-- 2) Today --}}
  <div class="col-xl col-lg-4 col-md-6">
    <div class="card border-0 shadow-sm h-100" style="border-top:4px solid #4CAF50 !important;">
      <div class="card-body text-center">
        <div class="mb-2">
          <i class="fas fa-calendar-day fa-2x" style="color:#4CAF50;"></i>
        </div>
        <h5 class="card-title">{{ __('messages.shop_visits.daily_stats') }}</h5>
        <div class="fw-bold" style="font-size:1.2rem;color:#1f2937;">{{ $stats['today_visits'] }}
          {{ __('messages.shop_visits.visits') }}</div>
        <div class="fw-semibold" style="font-size:1.05rem;color:#4CAF50;">{{ $stats['today_active_sales'] }}
          {{ __('messages.shop_visits.active_cards') }}</div>
      </div>
    </div>
  </div>

  {{-- 3) Previous working day --}}
  <div class="col-xl col-lg-4 col-md-6">
    <div class="card border-0 shadow-sm h-100" style="border-top:4px solid #8BC34A !important;">
      <div class="card-body text-center">
        <div class="mb-2">
          <i class="fas fa-history fa-2x" style="color:#8BC34A;"></i>
        </div>
        <h5 class="card-title">{{ __('messages.shop_visits.previous_working_day_stats') }}</h5>
        <div class="fw-bold" style="font-size:1.2rem;color:#1f2937;">{{ $stats['previous_working_day_visits'] }}
          {{ __('messages.shop_visits.visits') }}</div>
        <div class="fw-semibold" style="font-size:1.05rem;color:#8BC34A;">
          {{ $stats['previous_working_day_active_sales'] }} {{ __('messages.shop_visits.active_cards') }}</div>
      </div>
    </div>
  </div>

  {{-- 4) This week --}}
  <div class="col-xl col-lg-6 col-md-6">
    <div class="card border-0 shadow-sm h-100" style="border-top:4px solid #009688 !important;">
      <div class="card-body text-center">
        <div class="mb-2">
          <i class="fas fa-calendar-week fa-2x" style="color:#009688;"></i>
        </div>
        <h5 class="card-title">{{ __('messages.shop_visits.weekly_stats') }}</h5>
        <div class="fw-bold" style="font-size:1.2rem;color:#1f2937;">{{ $stats['weekly_visits'] }}
          {{ __('messages.shop_visits.visits') }}</div>
        <div class="fw-semibold" style="font-size:1.05rem;color:#009688;">{{ $stats['weekly_active_sales'] }}
          {{ __('messages.shop_visits.active_cards') }}</div>
      </div>
    </div>
  </div>

  {{-- 5) This month --}}
  <div class="col-xl col-lg-6 col-md-6">
    <div class="card border-0 shadow-sm h-100" style="border-top:4px solid #FF9800 !important;">
      <div class="card-body text-center">
        <div class="mb-2">
          <i class="fas fa-calendar-alt fa-2x" style="color:#FF9800;"></i>
        </div>
        <h5 class="card-title">{{ __('messages.shop_visits.monthly_stats') }}</h5>
        <div class="fw-bold" style="font-size:1.2rem;color:#1f2937;">{{ $stats['monthly_visits'] }}
          {{ __('messages.shop_visits.visits') }}</div>
        <div class="fw-semibold" style="font-size:1.05rem;color:#FF9800;">{{ $stats['monthly_active_sales'] }}
          {{ __('messages.shop_visits.active_cards') }}</div>
      </div>
    </div>
  </div>
</div>
