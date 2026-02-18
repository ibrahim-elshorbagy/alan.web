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

  .promo-top-bar-track {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: rgba(255, 255, 255, 0.15);
    z-index: 9999;
  }
  .promo-top-bar-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transition: none;
  }

  .promo-wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 16px;
    padding-top: 21px;
  }

  .promo-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 30px;
    padding: 7px 18px;
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom: 18px;
  }
  .promo-badge i {
    color: #ffd700;
  }
  .promo-badge .divider {
    width: 1px;
    height: 14px;
    background: rgba(255, 255, 255, 0.3);
    display: inline-block;
  }
  .promo-badge .countdown-num {
    background: #e53e3e;
    color: #fff;
    font-weight: 700;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.78rem;
    flex-shrink: 0;
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
</style>
@endpush

@section('content')

<div class="promo-top-bar-track">
  <div class="promo-top-bar-fill" id="promoBar"></div>
</div>

<div class="promo-wrapper" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

  {{-- Badge with countdown inside --}}
  <div class="promo-badge">
    <i class="fa-solid fa-bullhorn"></i>
    {{ __('messages.sales_advertise.ad_label') }}
    <span class="divider"></span>
    <i class="fa-regular fa-clock"></i>
    <span class="countdown-num" id="timerBadge">{{ $duration }}</span>
  </div>

  {{-- Card --}}
  <div class="promo-card">
    <div class="promo-photo-box">
      <img src="{{ $imageUrl }}" alt="" class="promo-photo" loading="eager">
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  var promoDuration = @json($duration);
  var promoDestination = @json($destinationUrl);

  (function() {
    var elapsed = 0;
    var interval = 50;
    var bar = document.getElementById('promoBar');
    var badge = document.getElementById('timerBadge');

    var timer = setInterval(function() {
      elapsed += interval;
      var pct = Math.min((elapsed / (promoDuration * 1000)) * 100, 100);
      var remaining = Math.max(Math.ceil((promoDuration * 1000 - elapsed) / 1000), 0);

      bar.style.width = pct + '%';
      badge.textContent = remaining;

      if (elapsed >= promoDuration * 1000) {
        clearInterval(timer);
        window.location.href = promoDestination;
      }
    }, interval);
  })();
</script>
@endpush
