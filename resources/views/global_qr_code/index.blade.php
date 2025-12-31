@extends('layouts.app')

@section('title')
  {{ __('messages.global_qr_code.title') }}
@endsection

@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h1>{{ __('messages.global_qr_code.title') }}</h1>
        </div>
        <div class="col-lg-12 mb-4">
          <div class=" alert-info alert " role="alert">
            <i class="fas fa-info-circle me-2"></i>
            {{ __('messages.global_qr_code.description') }}
          </div>
        </div>

        <div class="col-lg-12">
          <form method="POST" action="{{ route('global.qr.code.store') }}" id="globalQrCodeForm">
            @csrf
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <!-- QR Code Preview Grid -->
                  <div class="col-lg-12 mb-4">
                    <div class="card">
                      <div class="card-body">

                        @if ($vcards->count() > 0 || $whatsappStores->count() > 0)
                          <div class="row">
                            <!-- vCards QR Codes -->
                            @foreach ($vcards as $vcard)
                              <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                  <div class="card-body text-center">
                                    <div class="qr-code p-3 mb-3 d-flex justify-content-center align-items-center"
                                      style="background: {{ $customQrCode['background_color'] ?? '#ffffff' }}; min-height: 200px;">
                                      @if (isset($customQrCode['applySetting']) && $customQrCode['applySetting'] == 1)
                                        {!! QrCode::color(
                                            $qrcodeColor['qrcodeColor']->red(),
                                            $qrcodeColor['qrcodeColor']->green(),
                                            $qrcodeColor['qrcodeColor']->blue(),
                                        )->backgroundColor(
                                                $qrcodeColor['background_color']->red(),
                                                $qrcodeColor['background_color']->green(),
                                                $qrcodeColor['background_color']->blue(),
                                            )->style($customQrCode['style'])->eye($customQrCode['eye_style'])->size(150)->format('svg')->generate(route('vcard.show', $vcard->url_alias)) !!}
                                      @else
                                        {!! QrCode::size(150)->format('svg')->generate(route('vcard.show', $vcard->url_alias)) !!}
                                      @endif
                                    </div>
                                    <small class="text-muted">{{ route('vcard.show', $vcard->url_alias) }}</small>
                                  </div>
                                </div>
                              </div>
                            @endforeach

                            <!-- WhatsApp Stores QR Codes -->
                            @foreach ($whatsappStores as $store)
                              <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                  <div class="card-body text-center">
                                    <div class="qr-code p-3 mb-3 d-flex justify-content-center align-items-center"
                                      style="background: {{ $customQrCode['background_color'] ?? '#ffffff' }}; min-height: 200px;">
                                      @if (isset($customQrCode['applySetting']) && $customQrCode['applySetting'] == 1)
                                        {!! QrCode::color(
                                            $qrcodeColor['qrcodeColor']->red(),
                                            $qrcodeColor['qrcodeColor']->green(),
                                            $qrcodeColor['qrcodeColor']->blue(),
                                        )->backgroundColor(
                                                $qrcodeColor['background_color']->red(),
                                                $qrcodeColor['background_color']->green(),
                                                $qrcodeColor['background_color']->blue(),
                                            )->style($customQrCode['style'])->eye($customQrCode['eye_style'])->size(150)->format('svg')->generate(route('whatsapp.store.show', $store->url_alias)) !!}
                                      @else
                                        {!! QrCode::size(150)->format('svg')->generate(route('whatsapp.store.show', $store->url_alias)) !!}
                                      @endif
                                    </div>
                                    <small
                                      class="text-muted">{{ route('whatsapp.store.show', $store->url_alias) }}</small>
                                  </div>
                                </div>
                              </div>
                            @endforeach
                          </div>
                        @else
                          <div class="text-center py-5">
                            <i class="fas fa-qrcode fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('messages.global_qr_code.no_entities') }}</h5>
                            <p class="text-muted">{{ __('messages.global_qr_code.create_entities_first') }}</p>
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>

                  <!-- QR Code Settings -->
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header">
                        <h5 class="mb-0">{{ __('messages.global_qr_code.settings') }}</h5>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6 mb-4">
                            {{ Form::label('qrcode_color', __('messages.vcard.qrcode_color') . ':', ['class' => 'form-label required']) }}
                            {{ Form::color('qrcode_color', $customQrCode['qrcode_color'] ?? '#000000', ['class' => 'form-control form-control-color w-100', 'id' => 'qrcode_color', 'required']) }}
                          </div>

                          <div class="col-md-6 mb-4">
                            {{ Form::label('background_color', __('messages.vcard.back_color') . ':', ['class' => 'form-label required']) }}
                            {{ Form::color('background_color', $customQrCode['background_color'] ?? '#ffffff', ['class' => 'form-control form-control-color w-100', 'id' => 'background_color', 'required']) }}
                          </div>

                          <div class="col-md-6 mb-4">
                            <label for="style"
                              class="form-label required">{{ __('messages.vcard.qrcode_style') }}</label>
                            @php
                              $qrcodeStyle = collect(App\Models\QrcodeEdit::QRCODE_STYLE)->map(function ($value) {
                                  return trans('messages.qr_code.' . $value);
                              });
                            @endphp
                            {{ Form::select('style', $qrcodeStyle, $customQrCode['style'] ?? 'square', ['class' => 'form-control form-select', 'data-control' => 'select2', 'id' => 'qrcodeStyle', 'required']) }}
                          </div>

                          <div class="col-md-6 mb-4">
                            <label for="eye_style"
                              class="form-label required">{{ __('messages.vcard.qrcode_eye_style') }}</label>
                            @php
                              $qrcodeEyeStyle = collect(App\Models\QrcodeEdit::QRCODE_EYE_STYLE)->map(function (
                                  $value,
                              ) {
                                  return trans('messages.qr_code.' . $value);
                              });
                            @endphp
                            {{ Form::select('eye_style', $qrcodeEyeStyle, $customQrCode['eye_style'] ?? 'square', ['class' => 'form-control form-select', 'data-control' => 'select2', 'id' => 'qrcodeEyeStyle', 'required']) }}
                          </div>
                        </div>

                        <input type="hidden" name="applySetting" value="1">

                        <div class="d-flex justify-content-end">
                          <button type="submit" class="btn btn-primary" id="saveGlobalQrCode">
                            <i class="fas fa-save me-2"></i>
                            {{ __('messages.common.save') }}
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      // Form submission handler
      $('#globalQrCodeForm').on('submit', function(e) {
        $('#saveGlobalQrCode').prop('disabled', true);
      });
    });
  </script>
@endsection
