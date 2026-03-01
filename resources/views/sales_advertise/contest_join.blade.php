@extends('layouts.guest_simple')
@section('title')
  {{ __('messages.contest.join_contest') }}
@endsection
@push('styles')
  <style>
    body {
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%) !important;
      padding: 0 !important;
      align-items: stretch !important;
      min-height: 100vh;
    }

    .contest-wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .contest-card {
      width: 100%;
      max-width: 480px;
      background: #fff;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
      padding: 0;
    }

    .contest-header {
      background: linear-gradient(135deg, #ffd700, #ff8c00);
      padding: 24px 28px;
      text-align: center;
      color: #1a1a2e;
    }

    .contest-header h2 {
      margin: 0 0 6px;
      font-size: 1.4rem;
      font-weight: 800;
    }

    .contest-header .contest-desc {
      font-size: 0.9rem;
      opacity: 0.85;
      margin: 0;
    }

    .contest-body {
      padding: 28px;
    }

    .contest-countdown-row {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
    }

    .cd-item {
      background: linear-gradient(135deg, #1a1a2e, #16213e);
      color: #fff;
      border-radius: 12px;
      padding: 10px 14px;
      min-width: 58px;
      text-align: center;
    }

    .cd-item .cd-num {
      font-size: 1.5rem;
      font-weight: 700;
      display: block;
    }

    .cd-item .cd-lbl {
      font-size: 0.65rem;
      opacity: 0.7;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .contest-form .form-label {
      font-weight: 600;
      font-size: 0.9rem;
    }

    .contest-form .form-control {
      border: 2px solid #e5e7eb;
      border-radius: 12px;
      padding: 10px 14px;
      font-size: 1rem;
      transition: border-color 0.3s;
    }

    .contest-form .form-control:focus {
      border-color: #ffd700;
      box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.15);
    }

    .contest-submit-btn {
      display: block;
      width: 100%;
      background: linear-gradient(135deg, #ffd700, #ff8c00);
      color: #1a1a2e;
      font-weight: 700;
      border: none;
      border-radius: 14px;
      padding: 12px;
      font-size: 1.05rem;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
      margin-top: 16px;
    }

    .contest-submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
    }

    .phone-hint {
      font-size: 0.78rem;
      color: #888;
      margin-top: 4px;
    }

    .alert {
      border-radius: 12px;
      border: none;
      font-size: 0.9rem;
    }
  </style>
@endpush

@section('content')
  <div class="contest-wrapper" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="contest-card">
      {{-- Header --}}
      <div class="contest-header">
        <h2><i class="fa-solid fa-trophy me-2"></i>{{ $contest->title ?? __('messages.contest.contest') }}</h2>
        @if(!empty($contest->text))
          <p class="contest-desc">{{ $contest->text }}</p>
        @endif
      </div>

      <div class="contest-body">
        {{-- Countdown --}}
        <div class="contest-countdown-row">
          <div class="cd-item"><span class="cd-num" id="cDays">--</span><span
              class="cd-lbl">{{ __('messages.contest.days') }}</span></div>
          <div class="cd-item"><span class="cd-num" id="cHours">--</span><span
              class="cd-lbl">{{ __('messages.contest.hours') }}</span></div>
          <div class="cd-item"><span class="cd-num" id="cMins">--</span><span
              class="cd-lbl">{{ __('messages.contest.minutes') }}</span></div>
          <div class="cd-item"><span class="cd-num" id="cSecs">--</span><span
              class="cd-lbl">{{ __('messages.contest.seconds_label') }}</span></div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
          <div class="alert alert-success text-center mb-3">
            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
          </div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger text-center mb-3">
            <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
          </div>
        @endif
        @if($errors->any())
          <div class="alert alert-danger mb-3">
            <ul class="mb-0 ps-3">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- Join form --}}
        @if(!session('success'))
          <form method="POST" action="{{ route('contest.store', $contest->id) }}" class="contest-form">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">{{ __('messages.contest.participant_name') }}</label>
              <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                placeholder="{{ __('messages.contest.name_placeholder') }}" required>
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">{{ __('messages.contest.participant_phone') }}</label>
              <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone') }}"
                placeholder="07XXXXXXXX" required dir="ltr" pattern="^(0?7[789]\d{7}|9627[789]\d{7})$">
              <div class="phone-hint">{{ __('messages.contest.phone_hint') }}</div>
            </div>
            <button type="submit" class="contest-submit-btn">
              <i class="fa-solid fa-hand-pointer me-1"></i> {{ __('messages.contest.join_now') }}
            </button>
          </form>
        @endif
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    (function () {
      var drawDate = new Date(@json($contest->draw_date->toIso8601String()));
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
  </script>
@endpush