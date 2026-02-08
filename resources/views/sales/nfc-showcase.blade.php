@extends('layouts.app')
@section('title')
  {{ __('messages.common.nfc_cards_showcase') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="col-12">
      @include('layouts.errors')
    </div>
    <div class="d-flex justify-content-between align-items-end mb-5">
      <h1>{{ __('messages.common.nfc_cards_showcase') }}</h1>
      <a class="btn btn-outline-primary float-end"
        href="{{ route('sadmin.dashboard') }}">{{ __('messages.common.back') }}</a>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="mb-3">
            <label class="form-label">{{ __('NFC Card Types') }}</label>
          </div>
          @foreach ($nfcCards as $nfcCard)
            <div class="col-md-4 col-sm-6 g-5 nfccard"
              onclick="event.preventDefault(); event.stopPropagation(); return false;">
              <div class="flip-card" onclick="event.preventDefault(); event.stopPropagation(); return false;">
                <div class="flip-card-inner">
                  <div class="flip-card-front">
                    <div class="card nfc-img-radio img-fluid">
                      @if (!empty($nfcCard['media']) && count($nfcCard['media']) > 0)
                        <img src="{{ $nfcCard->nfc_image }}" class="card-img-top rounded nfc-card-img"
                          alt="{{ $nfcCard['media'][0]['original_url'] }}"
                          onerror="this.onerror=null; this.src='{{ asset('assets/img/nfc/card_default.png') }}';" />
                      @endif
                    </div>
                  </div>
                  <div class="flip-card-back">
                    <div class="card nfc-img-radio img-fluid">
                      @if (!empty($nfcCard['media']) && count($nfcCard['media']) > 0)
                        <img src="{{ $nfcCard->nfc_back_image }}" class="card-img-top rounded nfc-card-img"
                          alt="{{ $nfcCard['media'][0]['original_url'] }}"
                          onerror="this.onerror=null; this.src='{{ asset('assets/img/nfc/card_default.png') }}';" />
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="">
                <div class="mt-5 nfc-price fs-3" id="nfc-price">
                  <!-- First line: full-width name -->
                  <div class="w-100">
                    {{ $nfcCard['name'] }}
                  </div>

                  <!-- Second line: prices -->
                  <div class="text-primary w-100">
                    {{ __('messages.admin_price') }}:
                    {{ $currency . (getSuperAdminSettingValue('hide_decimal_values') == 1 ? number_format($nfcCard['price'], 0) : number_format($nfcCard['price'], 2)) }}
                    <br>
                    {{ __('messages.common.sales_price') }}:
                    {{ $currency . (getSuperAdminSettingValue('hide_decimal_values') == 1 ? number_format($nfcCard['sales_price'], 0) : number_format($nfcCard['sales_price'], 2)) }}
                  </div>
                </div>

              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection
<style>
  .flip-card {
    background-color: transparent;
    width: 300px;
    height: 200px;
    perspective: 1000px;
    margin: 0 auto;
  }

  .flip-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    text-align: center;
    transition: transform 0.8s;
    transform-style: preserve-3d;
  }

  .flip-card:hover .flip-card-inner {
    transform: rotateY(180deg);
  }

  .flip-card-front,
  .flip-card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
  }

  .flip-card-back {
    transform: rotateY(180deg);
  }

  .nfc-card-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }
</style>
