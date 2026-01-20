@extends('layouts.app')
@section('title')
  {{ __('messages.redirect_links.create') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h1>{{ __('messages.redirect_links.create') }}</h1>
          <a class="btn btn-outline-primary float-end"
            href="{{ route('redirect-links.index') }}">{{ __('messages.common.back') }}</a>
        </div>
        <div class="col-12">
          @include('layouts.errors')
        </div>
        <div class="card">
          <div class="card-body">
            {!! Form::open([
                'route' => 'redirect-links.store',
                'method' => 'post',
                'id' => 'createForm',
            ]) !!}
            @include('admin.redirect_links.fields_create')
            {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // NFC data
    const nfcData = @json($nfcs->keyBy('id')->toArray());

    // Show NFC price info when NFC is selected
    document.getElementById('nfcsSelect').addEventListener('change', function() {
      const nfcId = this.value;
      const priceInfo = document.getElementById('nfcPriceInfo');

      if (nfcId && nfcData[nfcId]) {
        const nfc = nfcData[nfcId];
        document.getElementById('nfcPrice').textContent = nfc.price ? '{{ currencyFormat(0, 0) }}'.replace('0', nfc
          .price) : 'N/A';
        document.getElementById('nfcSalesPrice').textContent = nfc.sales_price ? '{{ currencyFormat(0, 0) }}'.replace(
          '0', nfc.sales_price) : 'N/A';
        priceInfo.style.display = 'block';
      } else {
        priceInfo.style.display = 'none';
      }
    });

    document.getElementById('createForm').addEventListener('submit', function(e) {
      e.preventDefault();

      // Create form data
      const formData = new FormData(this);

      // Open download in new tab
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '{{ route('redirect-links.store') }}';
      form.target = '_blank';

      // Add CSRF token
      const csrfInput = document.createElement('input');
      csrfInput.type = 'hidden';
      csrfInput.name = '_token';
      csrfInput.value = '{{ csrf_token() }}';
      form.appendChild(csrfInput);

      // Add all form fields
      for (let [key, value] of formData.entries()) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
      }

      document.body.appendChild(form);
      form.submit();
      document.body.removeChild(form);

      // Redirect current page with flash message parameter
      setTimeout(function() {
        window.location.href = '{{ route('redirect-links.index') }}?success=1';
      }, 500);
    });
  </script>
@endsection
