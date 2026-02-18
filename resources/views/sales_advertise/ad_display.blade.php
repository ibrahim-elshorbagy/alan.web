@extends('layouts.guest_simple')

@section('title')
{{ __('messages.sales_advertise.ad_page_title') }}
@endsection

@push('styles')
<style>
  body {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%) !important;
    padding: 0 !important;
    align-items: stretch !important;
    min-height: 100vh;
  }

  .promo-wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 16px;
  }

  .promo-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 30px;
    padding: 6px 18px;
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom: 18px;
  }

  .promo-badge i {
    color: #ffd700;
  }

  .promo-card {
    width: 100%;
    max-width: 430px;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
  }

  .promo-photo-box {
    position: relative;
    width: 100%;
    background: #000;
    aspect-ratio: 9 / 16;
    overflow: hidden;
  }

  .promo-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .promo-footer {
    padding: 18px 22px 20px;
    background: #fff;
  }

  .timer-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
  }

  .timer-text {
    font-size: 0.9rem;
    color: #4a5568;
    font-weight: 500;
  }

  .timer-badge {
    background: #e53e3e;
    color: #fff;
    border-radius: 20px;
    padding: 3px 13px;
    font-size: 0.88rem;
    font-weight: 700;
    min-width: 36px;
    text-align: center;
  }

  .promo-bar-track {
    height: 6px;
    border-radius: 4px;
    background: #e2e8f0;
    overflow: hidden;
  }

  .promo-bar-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 4px;
    transition: none;
  }

</style>
@endpush

@section('content')
<div class="promo-wrapper" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

  {{-- Label --}}
  <div class="promo-badge">
    <i class="fa-solid fa-bullhorn"></i>
    {{ __('messages.sales_advertise.ad_label') }}
  </div>

  {{-- Card --}}
  <div class="promo-card">
    <div class="promo-photo-box">
      <img src="{{ $imageUrl }}" alt="" class="promo-photo" loading="eager">
    </div>

    <div class="promo-footer">
      <div class="timer-row">
        <span class="timer-text" id="timerText">
          {{ __('messages.sales_advertise.ad_closes_in', ['seconds' => $duration]) }}
        </span>
        <span class="timer-badge" id="timerBadge">{{ $duration }}</span>
      </div>
      <div class="promo-bar-track">
        <div class="promo-bar-fill" id="promoBar"></div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  var promoDuration = @json($duration);
  var promoDestination = @json($destinationUrl);
  var promoTemplate = @json(__('messages.sales_advertise.ad_closes_in_template'));

  (function() {
    var elapsed = 0;
    var interval = 50;

    var bar = document.getElementById('promoBar');
    var badge = document.getElementById('timerBadge');
    var text = document.getElementById('timerText');

    var timer = setInterval(function() {
      elapsed += interval;
      var pct = Math.min((elapsed / (promoDuration * 1000)) * 100, 100);
      var remaining = Math.max(Math.ceil((promoDuration * 1000 - elapsed) / 1000), 0);

      bar.style.width = pct + '%';
      badge.textContent = remaining;
      text.textContent = promoTemplate.replace(':seconds', remaining);

      if (elapsed >= promoDuration * 1000) {
        clearInterval(timer);
        window.location.href = promoDestination;
      }
    }, interval);
  })();

</script>
@endpush
