@extends('layouts.app')

@section('title')
{{ __('messages.sales_advertise.advertise_settings') }}
@endsection

@section('content')
<div class="container-fluid">
  <div class="d-flex flex-column">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-end mb-5">
        <h1>
          {{ __('messages.sales_advertise.advertise_settings') }}
          <small class="text-muted fs-6 ms-2">– {{ $salesUser->first_name }} {{ $salesUser->last_name }}</small>
        </h1>
        <a class="btn btn-outline-primary float-end" href="{{ route('admins.index') }}">
          {{ __('messages.common.back') }}
        </a>
      </div>

      <div class="col-12">
        @include('layouts.errors')
      </div>

      @include('flash::message')

      <div class="card">
        <div class="card-body">
          <form action="{{ route('sadmin.sales.advertise.update', $salesUser->id) }}" method="POST" enctype="multipart/form-data" id="advertiseForm">
            @csrf
            @method('PUT')

            {{-- Enable / Disable (super_admin only) --}}
            <div class="mb-4">
              <label class="form-label fw-bold">
                {{ __('messages.sales_advertise.enable_advertise') }}
              </label>
              <div class="d-flex gap-4 mt-2">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="is_enabled" id="enabledYes" value="1" {{ ($setting->is_enabled ?? false) ? 'checked' : '' }} onchange="toggleFields(this.value)">
                  <label class="form-check-label" for="enabledYes">
                    {{ __('messages.sales_advertise.yes') }}
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="is_enabled" id="enabledNo" value="0" {{ (!($setting->is_enabled ?? false)) ? 'checked' : '' }} onchange="toggleFields(this.value)">
                  <label class="form-check-label" for="enabledNo">
                    {{ __('messages.sales_advertise.no') }}
                  </label>
                </div>
              </div>
            </div>

            {{-- Fields shown only when enabled --}}
            <div id="advertiseFields" style="{{ ($setting->is_enabled ?? false) ? '' : 'display:none;' }}">

              {{-- Duration --}}
              <div class="mb-4">
                <label for="duration" class="form-label fw-bold">
                  {{ __('messages.sales_advertise.duration_label') }}
                  <span class="text-muted small">({{ __('messages.sales_advertise.duration_hint') }})</span>
                </label>
                <select name="duration" id="duration" class="form-select w-auto">
                  @for($i = 1; $i <= 5; $i++) <option value="{{ $i }}" {{ ($setting->duration ?? 3) == $i ? 'selected' : '' }}>
                    {{ $i }} {{ __('messages.sales_advertise.seconds') }}
                    </option>
                    @endfor
                </select>
              </div>

              {{-- Existing images + impressions merged --}}
              @php
              $images = $setting->images ?? [];
              $impressions = $setting->impressions ?? [];
              @endphp
              @if(count($images))
              <div class="mb-4">
                <label class="form-label fw-bold">
                  {{ __('messages.sales_advertise.current_images') }}
                  <span class="text-muted small ms-2">
                    <i class="fa-solid fa-chart-bar me-1"></i>{{ __('messages.sales_advertise.ad_impressions') }}
                  </span>
                </label>
                <div class="d-flex flex-wrap gap-3 mt-2" id="existingImages">
                  @foreach($images as $idx => $imgPath)
                  <div class="position-relative text-center" id="img-wrap-{{ $idx }}">
                    {{-- Portrait thumbnail --}}
                    <img src="{{ asset($imgPath) }}" alt="" style="width:90px;height:160px;object-fit:cover;border-radius:6px;border:1px solid #ddd;display:block;">
                    {{-- Delete button top-right --}}
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0 px-1" style="line-height:1.2;" onclick="markForDelete({{ $idx }}, this)">
                      <i class="fa-solid fa-times"></i>
                    </button>
                    {{-- Impression badge bottom-center --}}
                    <span class="badge bg-primary mt-1 d-inline-block">
                      <i class="fa-solid fa-eye me-1"></i>{{ $impressions[$imgPath] ?? 0 }}
                    </span>
                    <input type="hidden" name="delete_images[]" value="{{ $idx }}" id="del-{{ $idx }}" disabled>
                  </div>
                  @endforeach
                </div>
                <p class="text-muted small mt-2">
                  {{ __('messages.sales_advertise.images_count', ['count' => count($images), 'max' => 5]) }}
                </p>
              </div>
              @endif

              {{-- Upload new images --}}
              @php $remaining = 5 - count($images); @endphp
              @if($remaining > 0)
              <div class="mb-4">
                <label class="form-label fw-bold">
                  {{ __('messages.sales_advertise.add_images') }}
                  <span class="text-muted small">
                    ({{ __('messages.sales_advertise.max_images_hint', ['remaining' => $remaining]) }})
                  </span>
                </label>
                <input type="file" name="images[]" id="imageInput" class="form-control" multiple accept="image/*" max="{{ $remaining }}">
                <p class="text-muted small mt-1">
                  {{ __('messages.sales_advertise.compress_note') }}
                </p>
              </div>
              @else
              <div class="alert alert-info mb-4">
                {{ __('messages.sales_advertise.max_images_reached') }}
              </div>
              @endif

            </div>{{-- /advertiseFields --}}

            <div class="mt-3">
              <button type="submit" class="btn btn-primary px-5">
                {{ __('messages.common.save') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function toggleFields(val) {
    if (val === '1') {
      document.getElementById('advertiseFields').style.display = '';
    } else {
      document.getElementById('advertiseFields').style.display = 'none';
    }
  }

  function markForDelete(idx, btn) {
    var input = document.getElementById('del-' + idx);
    var wrap = document.getElementById('img-wrap-' + idx);
    if (input.disabled) {
      input.disabled = false;
      wrap.style.opacity = '0.4';
      btn.classList.replace('btn-danger', 'btn-secondary');
    } else {
      input.disabled = true;
      wrap.style.opacity = '1';
      btn.classList.replace('btn-secondary', 'btn-danger');
    }
  }

  // Limit file input to remaining slots
  var remainingSlots = @json($remaining ? ? 0);
  var maxAlert = @json(__('messages.sales_advertise.max_images_alert'));
  document.getElementById('imageInput') && document.getElementById('imageInput').addEventListener('change', function() {
    if (this.files.length > remainingSlots) {
      alert(maxAlert.replace(':max', remainingSlots));
      this.value = '';
    }
  });

</script>
@endpush
