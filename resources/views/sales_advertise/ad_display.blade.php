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

    /* Contest banner */
    .contest-banner {
      width: 100%;
      max-width: 430px;
      margin-bottom: 14px;
      background: linear-gradient(135deg, rgba(255, 215, 0, 0.15) 0%, rgba(255, 165, 0, 0.15) 100%);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 215, 0, 0.3);
      border-radius: 16px;
      padding: 14px 18px;
      color: #fff;
      text-align: center;
    }

    .contest-banner .contest-text-line {
      font-size: 0.92rem;
      margin-bottom: 8px;
      line-height: 1.5;
    }

    .contest-banner .contest-countdown {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin: 10px 0;
    }

    .contest-banner .countdown-item {
      background: rgba(255, 255, 255, 0.15);
      border-radius: 10px;
      padding: 6px 10px;
      min-width: 50px;
      text-align: center;
    }

    .contest-banner .countdown-item .num {
      font-size: 1.3rem;
      font-weight: 700;
      display: block;
    }

    .contest-banner .countdown-item .lbl {
      font-size: 0.65rem;
      opacity: 0.8;
      text-transform: uppercase;
    }

    .contest-banner .contest-join-btn {
      display: inline-block;
      background: linear-gradient(135deg, #ffd700, #ff8c00);
      color: #1a1a2e;
      font-weight: 700;
      border: none;
      border-radius: 25px;
      padding: 8px 28px;
      font-size: 0.9rem;
      text-decoration: none;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .contest-banner .contest-join-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
      color: #1a1a2e;
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

    {{-- Contest Banner --}}
    @if(!empty($contest))
      <div class="contest-banner">
        <div class="contest-text-line">
          <i class="fa-solid fa-trophy" style="color:#ffd700;"></i>
          <strong>{{ $contest['title'] ?? __('messages.contest.contest') }}</strong>
        </div>
        @if(!empty($contest['text']))
          <div class="contest-text-line">{{ $contest['text'] }}</div>
        @endif
        <div class="contest-countdown" id="contestCountdown">
          <div class="countdown-item"><span class="num" id="cDays">--</span><span
              class="lbl">{{ __('messages.contest.days') }}</span></div>
          <div class="countdown-item"><span class="num" id="cHours">--</span><span
              class="lbl">{{ __('messages.contest.hours') }}</span></div>
          <div class="countdown-item"><span class="num" id="cMins">--</span><span
              class="lbl">{{ __('messages.contest.minutes') }}</span></div>
          <div class="countdown-item"><span class="num" id="cSecs">--</span><span
              class="lbl">{{ __('messages.contest.seconds_label') }}</span></div>
        </div>
        <a href="{{ $contest['join_url'] }}" class="contest-join-btn" target="_blank">
          <i class="fa-solid fa-hand-pointer me-1"></i> {{ __('messages.contest.join_now') }}
        </a>
      </div>
    @endif

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

    (function () {
      var elapsed = 0;
      var interval = 50;
      var bar = document.getElementById('promoBar');
      var badge = document.getElementById('timerBadge');

      var timer = setInterval(function () {
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

    // Contest countdown
    @if(!empty($contest))
      (function () {
        var drawDate = new Date(@json($contest['draw_date']));
        function updateCountdown() {
          var now = new Date();
          var diff = drawDate - now;
          if (diff <= 0) {
            document.getElementById('cDays').textContent = '0';
            document.getElementById('cHours').textContent = '0';
            document.getElementById('cMins').textContent = '0';
            document.getElementById('cSecs').textContent = '0';
            return;
          }
          var d = Math.floor(diff / (1000 * 60 * 60 * 24));
          var h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
          var s = Math.floor((diff % (1000 * 60)) / 1000);
          document.getElementById('cDays').textContent = d;
          document.getElementById('cHours').textContent = h;
          document.getElementById('cMins').textContent = m;
          document.getElementById('cSecs').textContent = s;
        }
        updateCountdown();
        setInterval(updateCountdown, 1000);
      })();
    @endif
  </script>
@endpush