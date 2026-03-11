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
      padding: 6px 8px 8px;
      padding-top: 12px;
    }

    /* ── BADGE ─────────────────────────────────────── */
    .promo-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 30px;
      padding: 5px 12px;
      color: #fff;
      font-size: 0.80rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      margin-bottom: 8px;
      flex-shrink: 0;
    }

    .promo-badge i { color: #ffd700; }

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

    /* ── CONTEST BANNER ────────────────────────────── */
    .contest-banner {
      width: 100%;
      max-width: 430px;
      margin-bottom: 8px;
      background: linear-gradient(135deg, rgba(255, 215, 0, 0.18) 0%, rgba(255, 165, 0, 0.18) 100%);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 215, 0, 0.35);
      border-radius: 14px;
      padding: 10px 12px;
      color: #fff;
      text-align: center;
      flex-shrink: 0;
    }

    .contest-banner .contest-title {
      font-size: 1.4rem;
      font-weight: 800;
      line-height: 1.3;
      margin-bottom: 5px;
      text-shadow: 0 2px 8px rgba(0,0,0,0.4);
    }

    .contest-banner .contest-invite-text {
      font-size: 1rem;
      font-weight: 600;
      line-height: 1.45;
      margin-bottom: 7px;
      opacity: 0.95;
    }

    .contest-banner .contest-countdown {
      display: flex;
      justify-content: center;
      gap: 6px;
      margin: 6px 0;
    }

    .contest-banner .countdown-item {
      background: rgba(255, 255, 255, 0.15);
      border-radius: 8px;
      padding: 4px 7px;
      min-width: 42px;
      text-align: center;
    }

    .contest-banner .countdown-item .num {
      font-size: 1.15rem;
      font-weight: 700;
      display: block;
    }

    .contest-banner .countdown-item .lbl {
      font-size: 0.58rem;
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
      padding: 7px 24px;
      font-size: 0.88rem;
      text-decoration: none;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .contest-banner .contest-join-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
      color: #1a1a2e;
    }

    /* ── CARD & IMAGE ──────────────────────────────────────────
       THE FIX:
       • .promo-photo gets a max-height = viewport minus all the
         space used by badge + banner (calculated live in JS).
       • width: 100% normally fills the card.
       • When max-height is the limiting factor, object-fit:contain
         shows the full image within that height — browser
         automatically narrows the rendered width proportionally.
       • No cropping. Full image always visible. No scroll needed.
    ──────────────────────────────────────────────────────────── */
    .promo-card {
      width: 100%;
      max-width: 430px;
      background: transparent;
      overflow: visible;
      box-shadow: none;
    }

    .promo-photo-box {
      width: 100%;
      background: transparent;
      display: flex;
      justify-content: center;
    }

    .promo-photo {
      /* No object-fit: the img element IS the image, so border-radius
         clips the actual visible corners directly.
         max-width + max-height shrink proportionally to fit screen. */
      display: block;
      width: auto;
      height: auto;
      max-width: 100%;
      max-height: var(--img-max-h, calc(100svh - 60px));
      border-radius: 16px;
    }
  </style>
@endpush

@section('content')

  <div class="promo-top-bar-track">
    <div class="promo-top-bar-fill" id="promoBar"></div>
  </div>

  <div class="promo-wrapper" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- Badge --}}
    <div class="promo-badge" id="promoBadge">
      <i class="fa-solid fa-bullhorn"></i>
      {{ __('messages.sales_advertise.ad_label') }}
      <span class="divider"></span>
      <i class="fa-regular fa-clock"></i>
      <span class="countdown-num" id="timerBadge">{{ $duration }}</span>
    </div>

    {{-- Contest Banner --}}
    @if(!empty($contest))
      <div class="contest-banner" id="contestBanner">
        <div class="contest-title">
          <i class="fa-solid fa-trophy" style="color:#ffd700;"></i>
          {{ $contest['title'] ?? __('messages.contest.contest') }}
        </div>
        @if(!empty($contest['text']))
          <div class="contest-invite-text">{{ $contest['text'] }}</div>
        @endif
        <div class="contest-countdown">
          <div class="countdown-item"><span class="num" id="cDays">--</span><span class="lbl">{{ __('messages.contest.days') }}</span></div>
          <div class="countdown-item"><span class="num" id="cHours">--</span><span class="lbl">{{ __('messages.contest.hours') }}</span></div>
          <div class="countdown-item"><span class="num" id="cMins">--</span><span class="lbl">{{ __('messages.contest.minutes') }}</span></div>
          <div class="countdown-item"><span class="num" id="cSecs">--</span><span class="lbl">{{ __('messages.contest.seconds_label') }}</span></div>
        </div>
        <a href="{{ $contest['join_url'] }}" class="contest-join-btn" target="_blank">
          <i class="fa-solid fa-hand-pointer me-1"></i> {{ __('messages.contest.join_now') }}
        </a>
      </div>
    @endif

    {{-- Card --}}
    <div class="promo-card">
      <div class="promo-photo-box">
        <img src="{{ $imageUrl }}" alt="" class="promo-photo" id="promoPhoto" loading="eager" style="border-radius: 16px;">
      </div>
    </div>

  </div>
@endsection

@push('scripts')
  <script>
    var promoDuration    = @json($duration);
    var promoDestination = @json($destinationUrl);

    /* ────────────────────────────────────────────────────────
       Calculate exactly how much vertical space is left for
       the image after badge + banner take their share, then
       set --img-max-h so the image never overflows the screen.
    ──────────────────────────────────────────────────────── */
    function setImageMaxHeight() {
      var vh        = window.innerHeight;
      var badge     = document.getElementById('promoBadge');
      var banner    = document.getElementById('contestBanner'); // null when no contest
      var PADDING   = 12 + 8;   // wrapper padding-top + padding-bottom
      var GAP       = 8 + 8;    // gap below badge + gap below banner
      var EXTRA     = 6;        // card border-radius visual room

      var badgeH  = badge  ? badge.offsetHeight  : 0;
      var bannerH = banner ? banner.offsetHeight : 0;

      var reserved = PADDING + badgeH + GAP + bannerH + EXTRA;
      var maxH     = Math.max(vh - reserved, 100);

      document.documentElement.style.setProperty('--img-max-h', maxH + 'px');
    }

    // Run immediately so it applies before image paints
    setImageMaxHeight();
    window.addEventListener('resize', setImageMaxHeight);
    // Re-run after fonts/layout settle (banner height may change)
    window.addEventListener('load', setImageMaxHeight);

    /* ── Progress bar + redirect timer ── */
    (function () {
      var elapsed  = 0;
      var interval = 50;
      var bar      = document.getElementById('promoBar');
      var badge    = document.getElementById('timerBadge');

      var timer = setInterval(function () {
        elapsed += interval;
        var pct       = Math.min((elapsed / (promoDuration * 1000)) * 100, 100);
        var remaining = Math.max(Math.ceil((promoDuration * 1000 - elapsed) / 1000), 0);

        bar.style.width   = pct + '%';
        badge.textContent = remaining;

        if (elapsed >= promoDuration * 1000) {
          clearInterval(timer);
          window.location.href = promoDestination;
        }
      }, interval);
    })();

    /* ── Contest countdown ── */
    @if(!empty($contest))
      (function () {
        var drawDate = new Date(@json($contest['draw_date']));
        function tick() {
          var diff = drawDate - new Date();
          if (diff <= 0) {
            ['cDays','cHours','cMins','cSecs'].forEach(function(id){
              document.getElementById(id).textContent = '0';
            });
            return;
          }
          document.getElementById('cDays').textContent  = Math.floor(diff / 86400000);
          document.getElementById('cHours').textContent = Math.floor((diff % 86400000) / 3600000);
          document.getElementById('cMins').textContent  = Math.floor((diff % 3600000)  / 60000);
          document.getElementById('cSecs').textContent  = Math.floor((diff % 60000)    / 1000);
        }
        tick();
        setInterval(tick, 1000);
      })();
    @endif
  </script>
@endpush
