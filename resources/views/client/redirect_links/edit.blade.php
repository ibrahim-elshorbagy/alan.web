@extends('layouts.app')
@section('title')
  {{ __('messages.redirect_links.edit') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h1>{{ __('messages.redirect_links.edit') }}</h1>
          <a class="btn btn-outline-primary float-end"
            href="{{ route('client.redirect-links.index') }}">{{ __('messages.common.back') }}</a>
        </div>
        <div class="col-12">
          @include('layouts.errors')
        </div>
        <div class="card">
          <div class="card-body">
            {!! Form::open(['route' => ['client.redirect-links.update', $redirectLink->id], 'method' => 'put']) !!}
            @include('client.redirect_links.fields')
            {{ Form::close() }}
          </div>
        </div>
        <div class="card mt-3">
          <div class="card-body">
            <div class="qr-code-image d-flex justify-content-center" id="qr-code-one">
              {!! QrCode::size(130)->format('svg')->generate(url('/auto-' . $redirectLink->uri)) !!}
            </div>
            <div class="d-flex justify-content-center mt-3">
              <a href="" class="btn btn-primary" id="qr-code-btn" download="qr_code.png">
                <i class="fa-solid fa-download"></i> {{ __('messages.common.download') }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const qrCodeOne = document.getElementById("qr-code-one");
    const svg = qrCodeOne.querySelector("svg");

    const blob = new Blob([svg.outerHTML], {
      type: 'image/svg+xml'
    });
    const url = URL.createObjectURL(blob);
    const image = document.createElement('img');
    image.src = url;
    image.addEventListener('load', () => {
      const canvas = document.createElement('canvas');
      canvas.width = canvas.height = 130;
      const context = canvas.getContext('2d');
      context.drawImage(image, 0, 0, canvas.width, canvas.height);
      const link = document.getElementById('qr-code-btn');
      link.href = canvas.toDataURL();
      URL.revokeObjectURL(url);
    });
  });
</script>
