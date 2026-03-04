<div class="row">
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('uri', __('messages.redirect_links.uri') . ':', ['class' => 'form-label']) }}
      {{ Form::text('uri', url('/auto-' . (isset($redirectLink) ? $redirectLink->uri : '')), ['class' => 'form-control', 'readonly']) }}
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('status', __('messages.redirect_links.status') . ':', ['class' => 'form-label']) }}
      {{ Form::select('status', [0 => __('messages.redirect_links.not_redeemed'), 1 => __('messages.redirect_links.redeemed'), 2 => __('messages.redirect_links.rejected')], isset($redirectLink) ? $redirectLink->status : null, ['class' => 'form-control', 'disabled']) }}
    </div>
  </div>
  @if (!empty($assignedUser))
    <p><strong>{{ __('messages.sold_by') }}</strong> {{ $assignedUser->first_name }}
      {{ $assignedUser->last_name }} -
      <a href="https://wa.me/{{ $assignedUser->contact }}" class="text-success" target="_blank"><i
          class="fab fa-whatsapp fa-sm"></i> {{ $assignedUser->contact }}</a>
    </p>
  @endif
  <div class="col-lg-6">
    <div class="">
      <label class="form-label">{{ __('messages.redirect_links.redirect_link_type') }}:</label>
      <p class="form-control-plaintext">
        {{ isset($redirectLink) ? \App\Enums\RedirectLinkTypeEnum::from($redirectLink->redirect_link_type)->label() : '' }}
      </p>
      <p class="form-control-plaintext">
        {{ $redirectLink->nfc->name ?? '' }}
      </p>
    </div>
  </div>


  @if (isset($redirectLink) && $redirectLink->redirect_link_type == 1)
    <div class="col-12 mb-4">
      <small class="text-muted">{!! nl2br(__('messages.redirect_links.website_redirect_note')) !!}</small>
    </div>

    @if (isset($userVCards) && count($userVCards) > 0)
      <div class="col-12 mb-4">
        <div class="p-4 my-4 rounded alert-info">
          <strong>{{ __('messages.redirect_links.vcard_redirect_info') }}</strong>
          <p class="mb-2 mt-2">{{ __('messages.redirect_links.select_existing_vcard') }}:</p>
        </div>
        <div class="list-group">
          @foreach ($userVCards as $vcard)
            <a href="#" class="list-group-item list-group-item-action"
              onclick="event.preventDefault(); document.getElementById('redirect_link').value = '{{ route('vcard.show', ['alias' => $vcard->url_alias]) }}';">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">{{ $vcard->name }}</h5>
                <small>{{ $vcard->occupation }}</small>
              </div>
              <p class="mb-1 text-muted small">{{ route('vcard.show', ['alias' => $vcard->url_alias]) }}</p>
            </a>
          @endforeach
        </div>
        {{-- <div class="mt-3">
          <a href="{{ route('vcards.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> {{ __('messages.redirect_links.create_new_vcard') }}
          </a>
        </div> --}}
      </div>
    @else
      <div class="col-12 mb-4">
        <div class="alert alert-warning">
          <strong>{{ __('messages.redirect_links.no_vcards_available') }}</strong>
          <p class="mb-2 mt-2">{{ __('messages.redirect_links.vcard_redirect_note') }}</p>
          <a href="{{ route('vcards.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> {{ __('messages.redirect_links.create_new_vcard') }}
          </a>
        </div>
      </div>
    @endif
  @endif

  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('redirect_link', __('messages.redirect_links.redirect_link') . ':', ['class' => 'form-label']) }}
      {{ Form::text('redirect_link', isset($redirectLink) ? $redirectLink->redirect_link : null, ['class' => 'form-control', 'id' => 'redirect_link', 'placeholder' => __('messages.redirect_links.redirect_link'), 'disabled' => isset($redirectLink) && $redirectLink->status == 2]) }}
      <small class="text-muted">{{ __('messages.redirect_links.valid_url_examples') }}<br>
        https://www.example.com<br>
        http://example.com</small>
    </div>
  </div>

  @php
    $adIsEnabled = isset($adSetting) && $adSetting && $adSetting->is_enabled;
  @endphp
  <div class="col-12 mb-4">
    <label class="form-label fw-bold">{{ __('messages.redirect_links.redirect_behavior') }}</label>
    <div class="d-flex gap-4 mt-2">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="redirect_behavior" id="behaviorDirect" value="direct"
          {{ !$adIsEnabled ? 'checked' : '' }}
          onchange="toggleAdSection(this.value)">
        <label class="form-check-label" for="behaviorDirect">{{ __('messages.redirect_links.direct_redirect') }}</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="redirect_behavior" id="behaviorAds" value="ads"
          {{ $adIsEnabled ? 'checked' : '' }}
          onchange="toggleAdSection(this.value)">
        <label class="form-check-label" for="behaviorAds">{{ __('messages.redirect_links.pause_for_ads') }}</label>
      </div>
    </div>
  </div>

  @if (isset($redirectLink) && $redirectLink->status == 2)
    <div class="col-12">
      <div class="alert alert-danger">
        <strong>{{ __('messages.redirect_links.rejected_note') }}</strong>
      </div>
    </div>
  @endif

  {{-- Advertisement Settings Section (only for active/redeemed links) --}}
  @if (isset($redirectLink) && $redirectLink->status != 2)
    @php
      $adSetting = $adSetting ?? null;
      $adImages = $adSetting ? ($adSetting->images ?? []) : [];
      $adRemaining = 5 - count($adImages);
    @endphp
    <div class="col-12 mt-4" id="adSection" style="{{ $adIsEnabled ? '' : 'display:none;' }}">
      <hr>
      <h4 class="mb-3"><i class="fa-solid fa-bullhorn me-2"></i>{{ __('messages.sales_advertise.advertise_settings') }}
      </h4>

      <input type="hidden" name="ad_is_enabled" id="ad_is_enabled" value="1">

      {{-- Fields shown only when enabled --}}
      <div id="adFields">

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
            <label class="form-label fw-bold">{{ __('messages.sales_advertise.current_images') }}</label>
            <div class="d-flex flex-wrap gap-3 mt-2">
              @foreach($adImages as $idx => $imgPath)
                <div class="position-relative text-center" id="ad-img-wrap-{{ $idx }}">
                  <img src="{{ asset($imgPath) }}" alt=""
                    style="width:90px;height:160px;object-fit:cover;border-radius:6px;border:1px solid #ddd;display:block;">
                  <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0 px-1"
                    style="line-height:1.2;" onclick="markAdForDelete({{ $idx }}, this)">
                    <i class="fa-solid fa-times"></i>
                  </button>
                  <input type="hidden" name="ad_delete_images[]" value="{{ $idx }}" id="ad-del-{{ $idx }}" disabled>
                </div>
              @endforeach
            </div>
            <p class="text-muted small mt-1">
              {{ __('messages.sales_advertise.images_count', ['count' => count($adImages), 'max' => 5]) }}
            </p>
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
            <p class="text-muted small mt-1">
              {{ __('messages.sales_advertise.compress_note') }}
            </p>
          </div>
        @else
          <div class="alert alert-info mb-4">
            {{ __('messages.sales_advertise.max_images_reached') }}
          </div>
        @endif

        {{-- Contest (مسابقة) Section — Multi-contest management --}}
        <hr class="my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0"><i class="fa-solid fa-trophy me-2"></i>{{ __('messages.contest.contest_settings') }}</h5>
          <a href="{{ route('contests.create', $redirectLink->id) }}" class="btn btn-sm btn-primary">
            <i class="fa-solid fa-plus me-1"></i> {{ __('messages.contest.add_contest') }}
          </a>
        </div>

        @php
          $contests = \App\Models\Contest::where('redirect_link_id', $redirectLink->id)->orderBy('created_at', 'desc')->get();
        @endphp

        {{-- Existing contests table --}}
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
    </div>
  @endif

  <div>
    @if (!isset($redirectLink) || $redirectLink->status != 2)
      {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
    @endif
    <a href="{{ route('client.redirect-links.index') }}"
      class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
  </div>
</div>

<script>
  function toggleAdSection(val) {
    var el = document.getElementById('adSection');
    if (el) el.style.display = (val === 'ads') ? '' : 'none';
    var hidden = document.getElementById('ad_is_enabled');
    if (hidden) hidden.value = (val === 'ads') ? '1' : '0';
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