@extends('layouts.app')
@section('title')
  {{ __('messages.sales_advertise.advertise_settings') }} - {{ $redirectLink->uri }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h1>
            <i class="fa-solid fa-bullhorn me-2"></i>{{ __('messages.sales_advertise.advertise_settings') }}
            <small class="text-muted fs-6">— {{ $redirectLink->uri }}</small>
          </h1>
          @if(auth()->user()->hasRole('super_admin'))
            <a class="btn btn-outline-primary float-end"
              href="{{ route('redirect-links.edit', $redirectLink->id) }}">{{ __('messages.common.back') }}</a>
          @else
            <a class="btn btn-outline-primary float-end"
              href="{{ route('client.redirect-links.index') }}">{{ __('messages.common.back') }}</a>
          @endif
        </div>

        <div class="col-12">
          @include('layouts.errors')
        </div>

        <div class="card">
          <div class="card-body">
            @php
              $adSetting = $adSetting ?? null;
              $adIsEnabled = $adSetting && $adSetting->is_enabled;
              $adImages = $adSetting ? ($adSetting->images ?? []) : [];
              $adImpressions = $adSetting ? ($adSetting->impressions ?? []) : [];
              $adRemaining = 5 - count($adImages);
              $isSuperAdmin = auth()->user()->hasRole('super_admin');
              $formAction = $isSuperAdmin
                ? route('redirect-links.ad-settings.update', $redirectLink->id)
                : route('client.redirect-links.ad-settings.update', $redirectLink->id);
            @endphp

            {!! Form::open([
                'url' => $formAction,
                'method' => 'post',
                'files' => true,
                'id' => 'adSettingsForm',
            ]) !!}

            {{-- Redirect Behavior Radio --}}
            <div class="mb-4">
              <label class="form-label fw-bold">
                {{ __('messages.redirect_links.redirect_behavior') }}
              </label>
              <div class="d-flex gap-4 mt-2">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="ad_is_enabled" id="adEnabledNo" value="0"
                    {{ !$adIsEnabled ? 'checked' : '' }} onchange="toggleAdFields(this.value)">
                  <label class="form-check-label" for="adEnabledNo">{{ __('messages.redirect_links.direct_redirect') }}</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="ad_is_enabled" id="adEnabledYes" value="1"
                    {{ $adIsEnabled ? 'checked' : '' }} onchange="toggleAdFields(this.value)">
                  <label class="form-check-label" for="adEnabledYes">{{ __('messages.redirect_links.pause_for_ads') }}</label>
                </div>
              </div>
            </div>

            {{-- Fields shown only when enabled --}}
            <div id="adFields" style="{{ $adIsEnabled ? '' : 'display:none;' }}">

              {{-- Duration --}}
              <div class="mb-4">
                <label for="ad_duration" class="form-label fw-bold">
                  {{ __('messages.sales_advertise.duration_label') }}
                  <span class="text-muted small">({{ __('messages.sales_advertise.duration_hint') }})</span>
                </label>
                <select name="ad_duration" id="ad_duration" class="form-select w-auto">
                  @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ ($adSetting ? $adSetting->duration : 3) == $i ? 'selected' : '' }}>
                      {{ $i }} {{ __('messages.sales_advertise.seconds') }}
                    </option>
                  @endfor
                </select>
              </div>

              {{-- Existing images --}}
              @if(count($adImages))
                <div class="mb-4">
                  <label class="form-label fw-bold">
                    {{ __('messages.sales_advertise.current_images') }}
                    @if($isSuperAdmin)
                      <span class="text-muted small ms-2">
                        <i class="fa-solid fa-chart-bar me-1"></i>{{ __('messages.sales_advertise.ad_impressions') }}
                      </span>
                    @endif
                  </label>
                  <div class="d-flex flex-wrap gap-3 mt-2">
                    @foreach($adImages as $idx => $imgPath)
                      <div class="position-relative text-center" id="ad-img-wrap-{{ $idx }}">
                        <img src="{{ asset($imgPath) }}" alt=""
                          style="width:90px;height:160px;object-fit:cover;border-radius:6px;border:1px solid #ddd;display:block;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0 px-1"
                          style="line-height:1.2;" onclick="markAdForDelete({{ $idx }}, this)">
                          <i class="fa-solid fa-times"></i>
                        </button>
                        {{-- Impression badge (super_admin only) --}}
                        @if($isSuperAdmin)
                          <span class="badge bg-primary mt-1 d-inline-block">
                            <i class="fa-solid fa-eye me-1"></i>{{ $adImpressions[$imgPath] ?? 0 }}
                          </span>
                        @endif
                        <input type="hidden" name="ad_delete_images[]" value="{{ $idx }}" id="ad-del-{{ $idx }}" disabled>
                      </div>
                    @endforeach
                  </div>
                  <p class="text-muted small mt-2">
                    {{ __('messages.sales_advertise.images_count', ['count' => count($adImages), 'max' => 5]) }}
                  </p>
                  {{-- Total impressions summary (super_admin only) --}}
                  @if($isSuperAdmin)
                    @php $totalImpressions = array_sum($adImpressions); @endphp
                    <p class="text-info small">
                      <i class="fa-solid fa-chart-line me-1"></i>
                      {{ __('messages.sales_advertise.total_impressions') }}: <strong>{{ $totalImpressions }}</strong>
                    </p>
                  @endif
                </div>
              @endif

              {{-- Upload new images --}}
              @if($adRemaining > 0)
                <div class="mb-4">
                  <label class="form-label fw-bold">
                    {{ __('messages.sales_advertise.add_images') }}
                    <span class="text-muted small">
                      ({{ __('messages.sales_advertise.max_images_hint', ['remaining' => $adRemaining]) }})
                    </span>
                  </label>
                  <input type="file" name="ad_images[]" id="adImageInput" class="form-control" multiple accept="image/*">
                  {{-- <p class="text-muted small mt-1">
                    {{ __('messages.sales_advertise.compress_note') }}
                  </p> --}}
                </div>
              @else
                <div class="alert alert-info mb-4">
                  {{ __('messages.sales_advertise.max_images_reached') }}
                </div>
              @endif

              {{-- Contest (مسابقة) Section --}}
              <hr class="my-4">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="fa-solid fa-trophy me-2"></i>{{ __('messages.contest.contest_settings') }}</h5>
                <a href="{{ route('contests.create', $redirectLink->id) }}" class="btn btn-sm btn-primary">
                  <i class="fa-solid fa-plus me-1"></i> {{ __('messages.contest.add_contest') }}
                </a>
              </div>

              @if($contests->count() > 0)
                <div class="table-responsive mb-4">
                  <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                      <tr>
                        <th>{{ __('messages.contest.contest_title') }}</th>
                        <th>{{ __('messages.contest.draw_date') }}</th>
                        <th>{{ __('messages.contest.num_winners') }}</th>
                        <th>{{ __('messages.contest.participants') }}</th>
                        <th>{{ __('messages.contest.status') }}</th>
                        <th style="width: 160px;">{{ __('messages.common.action') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($contests as $ct)
                        <tr id="contest-row-{{ $ct->id }}">
                          <td>{{ $ct->title }}</td>
                          <td>{{ $ct->draw_date->translatedFormat('Y-m-d h:i A') }}</td>
                          <td>{{ $ct->num_winners }}</td>
                          <td>
                            <a href="{{ route('contest.participants', $ct->id) }}"
                              class="badge bg-primary text-white text-decoration-none">
                              <i class="fa-solid fa-eye me-1"></i>{{ $ct->participants()->count() }}
                            </a>
                          </td>
                          <td>
                            <button type="button" id="toggle-btn-{{ $ct->id }}"
                              onclick="ajaxToggleContest({{ $ct->id }}, '{{ route('contests.toggle', $ct->id) }}')"
                              class="btn btn-sm {{ $ct->is_enabled ? 'btn-success' : 'btn-outline-secondary' }}">
                              <i class="fa-solid {{ $ct->is_enabled ? 'fa-toggle-on' : 'fa-toggle-off' }} me-1"
                                id="toggle-icon-{{ $ct->id }}"></i>
                              <span
                                id="toggle-label-{{ $ct->id }}">{{ $ct->is_enabled ? __('messages.contest.enabled') : __('messages.contest.disabled') }}</span>
                            </button>
                          </td>
                          <td>
                            <a href="{{ route('contests.edit', $ct->id) }}" class="btn btn-sm btn-info">
                              <i class="fa-solid fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                              onclick="ajaxDeleteContest({{ $ct->id }}, '{{ route('contests.destroy', $ct->id) }}', '{{ addslashes(__('messages.contest.confirm_delete')) }}')">
                              <i class="fa-solid fa-trash"></i>
                            </button>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif

            </div>{{-- /adFields --}}

            <div class="mt-4">
              {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
              @if($isSuperAdmin)
                <a href="{{ route('redirect-links.edit', $redirectLink->id) }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
              @else
                <a href="{{ route('client.redirect-links.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
              @endif
            </div>

            {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  function toggleAdFields(val) {
    var el = document.getElementById('adFields');
    if (el) el.style.display = (val === '1') ? '' : 'none';
  }

  function ajaxToggleContest(id, url) {
    var btn = document.getElementById('toggle-btn-' + id);
    var icon = document.getElementById('toggle-icon-' + id);
    var label = document.getElementById('toggle-label-' + id);
    if (btn) btn.disabled = true;
    var fd = new FormData();
    fd.append('_token', '{{ csrf_token() }}');
    fetch(url, {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: fd,
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (btn) btn.disabled = false;
        if (data.success) {
          var enabled = data.is_enabled;
          if (btn) btn.className = 'btn btn-sm ' + (enabled ? 'btn-success' : 'btn-outline-secondary');
          if (icon) icon.className = 'fa-solid ' + (enabled ? 'fa-toggle-on' : 'fa-toggle-off') + ' me-1';
          if (label) label.textContent = data.label;
          if (data.disabled_ids && data.disabled_ids.length) {
            data.disabled_ids.forEach(function (otherId) {
              var ob = document.getElementById('toggle-btn-' + otherId);
              var oi = document.getElementById('toggle-icon-' + otherId);
              var ol = document.getElementById('toggle-label-' + otherId);
              if (ob) ob.className = 'btn btn-sm btn-outline-secondary';
              if (oi) oi.className = 'fa-solid fa-toggle-off me-1';
              if (ol) ol.textContent = data.disabled_label || '';
            });
          }
          if (data.message) {
            toastr.success(data.message);
          }
        }
      })
      .catch(function () { if (btn) btn.disabled = false; });
  }

  function ajaxDeleteContest(id, url, confirmMsg) {
    if (!confirm(confirmMsg)) return;
    var fd = new FormData();
    fd.append('_token', '{{ csrf_token() }}');
    fd.append('_method', 'DELETE');
    fetch(url, {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: fd,
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.success) {
          var row = document.getElementById('contest-row-' + id);
          if (row) row.remove(); else window.location.reload();
        }
      })
      .catch(function () { window.location.reload(); });
  }

  function markAdForDelete(idx, btn) {
    var input = document.getElementById('ad-del-' + idx);
    var wrap = document.getElementById('ad-img-wrap-' + idx);
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
  var adRemainingSlots = @json($adRemaining ?? 0);
  var adMaxAlert = @json(__('messages.sales_advertise.max_images_alert'));
  var adInput = document.getElementById('adImageInput');
  if (adInput) {
    adInput.addEventListener('change', function () {
      if (this.files.length > adRemainingSlots) {
        alert(adMaxAlert.replace(':max', adRemainingSlots));
        this.value = '';
      }
    });
  }
</script>
@endpush


