@php
  $isDisabled = auth()->user()->hasRole('sales') && isset($redirectLink) && $redirectLink->status == 2;
@endphp
<div class="row">
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('user_id', __('messages.redirect_links.user') . ':', ['class' => 'form-label']) }}
      <div class="d-flex gap-2 align-items-start">
        <div class="flex-grow-1">
          {{ Form::select('user_id', $users->mapWithKeys(fn($user) => [$user->id => $user->first_name . ' ' . $user->last_name])->toArray(), isset($redirectLink) ? $redirectLink->user_id : null, ['class' => 'form-control', 'id' => 'user_id_select', 'placeholder' => __('messages.redirect_links.select_user'), 'disabled' => auth()->user()->hasRole('sales') || $isDisabled]) }}
          @if(auth()->user()->hasRole('sales'))
            {{-- Hidden field to submit user_id value when the select is disabled --}}
            <input type="hidden" name="user_id" id="user_id_hidden"
              value="{{ isset($redirectLink) ? $redirectLink->user_id : '' }}">
          @endif
        </div>
        @if(!$isDisabled && (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('sales')) && !isset($redirectLink->user_id))
          <button type="button" class="btn btn-sm btn-success mt-1" data-bs-toggle="modal"
            data-bs-target="#createQuickUserModal" title="{{ __('messages.redirect_links.quick_user.create_new_user') }}">
            <i class="fas fa-plus"></i>
          </button>
        @endif
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('uri', __('messages.redirect_links.redeem_code') . ':', ['class' => 'form-label required']) }}
      {{ Form::text('uri', isset($redirectLink) ? $redirectLink->uri : null, ['class' => 'form-control', 'placeholder' => __('messages.redirect_links.redeem_code'), 'required', 'disabled' => auth()->user()->hasRole('sales') || $isDisabled]) }}
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('redirect_link_type', __('messages.redirect_links.redirect_link_type') . ':', ['class' => 'form-label required']) }}
      {{ Form::select('redirect_link_type', collect(\App\Enums\RedirectLinkTypeEnum::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])->toArray(), isset($redirectLink) ? $redirectLink->redirect_link_type : null, ['class' => 'form-control', 'required', 'disabled' => auth()->user()->hasRole('sales') || $isDisabled]) }}
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('nfcs_id', __('messages.redirect_links.nfc') . ':', ['class' => 'form-label required']) }}
      {{ Form::select('nfcs_id', $nfcs->pluck('name', 'id'), isset($redirectLink) ? $redirectLink->nfcs_id : null, ['class' => 'form-control', 'required', 'disabled' => auth()->user()->hasRole('sales') || $isDisabled]) }}
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('redirect_link', __('messages.redirect_links.redirect_link') . ':', ['class' => 'form-label']) }}
      {{ Form::text('redirect_link', isset($redirectLink) ? $redirectLink->redirect_link : null, ['class' => 'form-control', 'placeholder' => __('messages.redirect_links.redirect_link'), 'disabled' => $isDisabled]) }}
    </div>
  </div>

  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('status', __('messages.redirect_links.status') . ':', ['class' => 'form-label required']) }}
      @if (auth()->user()->hasRole('sales'))
        @if (isset($redirectLink) && $redirectLink->status == 2)
          {{ Form::select('status', [2 => __('messages.redirect_links.rejected')], 2, ['class' => 'form-control', 'required', 'disabled' => true]) }}
        @else
          {{ Form::select('status', [0 => __('messages.redirect_links.not_redeemed'), 1 => __('messages.redirect_links.redeemed')], isset($redirectLink) ? $redirectLink->status : 0, ['class' => 'form-control', 'required', 'disabled' => $isDisabled]) }}
        @endif
      @else
        {{ Form::select('status', [0 => __('messages.redirect_links.not_redeemed'), 1 => __('messages.redirect_links.redeemed'), 2 => __('messages.redirect_links.rejected')], isset($redirectLink) ? $redirectLink->status : 0, ['class' => 'form-control', 'required', 'disabled' => $isDisabled]) }}
      @endif
    </div>
  </div>
  @if (auth()->user()->hasRole('super_admin'))
    <div class="col-lg-6">
      <div class="mb-5">
        {{ Form::label('price', __('messages.admin_price') . ':', ['class' => 'form-label']) }}
        {{ Form::number('price', isset($redirectLink) ? $redirectLink->price : null, ['class' => 'form-control', 'placeholder' => __('messages.admin_price'), 'step' => '0.01', 'min' => '0', 'disabled' => $isDisabled]) }}
      </div>
    </div>
    <div class="col-lg-6">
      <div class="mb-5">
        {{ Form::label('sales_price', __('messages.common.sales_price') . ':', ['class' => 'form-label']) }}
        {{ Form::number('sales_price', isset($redirectLink) ? $redirectLink->sales_price : null, ['class' => 'form-control', 'placeholder' => __('messages.selling_price'), 'step' => '0.01', 'min' => '0', 'disabled' => $isDisabled]) }}
      </div>
    </div>
  @endif
  @if (auth()->user()->hasRole('sales'))
    {{-- Sales can reassign to other sales or super admin --}}
    <div class="col-lg-6">
      <div class="mb-5">
        {{ Form::label('assigned_id', __('messages.redirect_links.assigned_to') . ':', ['class' => 'form-label']) }}
        {{ Form::select('assigned_id', $salesUsers->mapWithKeys(fn($user) => [$user->id => $user->first_name . ' ' . $user->last_name])->toArray(), isset($redirectLink) ? $redirectLink->assigned_id : null, ['class' => 'form-control', 'placeholder' => __('messages.redirect_links.select_assignee'), 'disabled' => $isDisabled]) }}
        <small class="text-muted">{{ __('messages.redirect_links.reassign_resets_received_status') }}</small>
      </div>
    </div>
  @elseif (!auth()->user()->hasRole('sales'))
    <div class="col-lg-6">
      <div class="mb-5">
        {{ Form::label('assigned_id', __('messages.redirect_links.assigned_to') . ':', ['class' => 'form-label']) }}
        {{ Form::select('assigned_id', $salesUsers->mapWithKeys(fn($user) => [$user->id => $user->first_name . ' ' . $user->last_name])->toArray(), isset($redirectLink) ? $redirectLink->assigned_id : null, ['class' => 'form-control', 'disabled' => $isDisabled]) }}
      </div>
    </div>
  @endif
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('received_status', __('messages.redirect_links.received_status') . ':', ['class' => 'form-label']) }}
      @if (auth()->user()->hasRole('sales'))
        {{ Form::select('received_status', [0 => __('messages.redirect_links.not_received'), 1 => __('messages.redirect_links.received')], isset($redirectLink) ? $redirectLink->received_status : 0, ['class' => 'form-control', 'disabled' => true]) }}
      @else
        {{ Form::select('received_status', [0 => __('messages.redirect_links.not_received'), 1 => __('messages.redirect_links.received')], isset($redirectLink) ? $redirectLink->received_status : 0, ['class' => 'form-control']) }}
      @endif
    </div>
    @if(isset($latestAcknowledgment))
      <div class="mb-3">
        <small class="text-info">
          <i class="fas fa-info-circle"></i>
          {{ __('messages.redirect_links.acknowledgment_info') }}: #{{ $latestAcknowledgment->id }}
        </small>
      </div>
    @endif
  </div>

  <div class="col-12">
    <div class="mb-5">
      {{ Form::label('note', __('messages.redirect_links.note') . ':', ['class' => 'form-label']) }}

      {{ Form::textarea('note', isset($redirectLink) ? $redirectLink->note : null, [
  'class' => 'form-control',
  'rows' => 4,
  'placeholder' => __('messages.redirect_links.note_placeholder'),
  'style' => 'resize: vertical;',
  'disabled' => $isDisabled,
]) }}
    </div>
  </div>

  {{-- Advertisement Settings Section (super_admin only, read-only for others) --}}
  @if (auth()->user()->hasRole('super_admin') && isset($redirectLink))
    @php
      $adSetting = $adSetting ?? null;
      $adImages = $adSetting ? ($adSetting->images ?? []) : [];
      $adImpressions = $adSetting ? ($adSetting->impressions ?? []) : [];
      $adRemaining = 5 - count($adImages);
    @endphp
    <div class="col-12 mt-4">
      <hr>
      <h4 class="mb-3"><i class="fa-solid fa-bullhorn me-2"></i>{{ __('messages.sales_advertise.advertise_settings') }}
      </h4>

      {{-- Enable / Disable --}}
      <div class="mb-4">
        <label class="form-label fw-bold">
          {{ __('messages.sales_advertise.enable_advertise') }}
        </label>
        <div class="d-flex gap-4 mt-2">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ad_is_enabled" id="adEnabledYes" value="1" {{ ($adSetting && $adSetting->is_enabled) ? 'checked' : '' }} onchange="toggleAdFields(this.value)">
            <label class="form-check-label" for="adEnabledYes">{{ __('messages.sales_advertise.yes') }}</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ad_is_enabled" id="adEnabledNo" value="0" {{ (!$adSetting || !$adSetting->is_enabled) ? 'checked' : '' }} onchange="toggleAdFields(this.value)">
            <label class="form-check-label" for="adEnabledNo">{{ __('messages.sales_advertise.no') }}</label>
          </div>
        </div>
      </div>

      {{-- Fields shown only when enabled --}}
      <div id="adFields" style="{{ ($adSetting && $adSetting->is_enabled) ? '' : 'display:none;' }}">

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

        {{-- Existing images + impressions --}}
        @if(count($adImages))
          <div class="mb-4">
            <label class="form-label fw-bold">
              {{ __('messages.sales_advertise.current_images') }}
              <span class="text-muted small ms-2">
                <i class="fa-solid fa-chart-bar me-1"></i>{{ __('messages.sales_advertise.ad_impressions') }}
              </span>
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
                  {{-- Impression badge --}}
                  <span class="badge bg-primary mt-1 d-inline-block">
                    <i class="fa-solid fa-eye me-1"></i>{{ $adImpressions[$imgPath] ?? 0 }}
                  </span>
                  <input type="hidden" name="ad_delete_images[]" value="{{ $idx }}" id="ad-del-{{ $idx }}" disabled>
                </div>
              @endforeach
            </div>
            <p class="text-muted small mt-2">
              {{ __('messages.sales_advertise.images_count', ['count' => count($adImages), 'max' => 5]) }}
            </p>
            {{-- Total impressions summary --}}
            @php $totalImpressions = array_sum($adImpressions); @endphp
            <p class="text-info small">
              <i class="fa-solid fa-chart-line me-1"></i>
              {{ __('messages.sales_advertise.total_impressions') }}: <strong>{{ $totalImpressions }}</strong>
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
              if (btn) {
                btn.className = 'btn btn-sm ' + (enabled ? 'btn-success' : 'btn-outline-secondary');
              }
              if (icon) {
                icon.className = 'fa-solid ' + (enabled ? 'fa-toggle-on' : 'fa-toggle-off') + ' me-1';
              }
              if (label) {
                label.textContent = data.label;
              }
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
              if (row) row.remove();
              else window.location.reload();
            }
          })
          .catch(function () { window.location.reload(); });
      }

      function submitContestForm() {
        var errorsDiv = document.getElementById('contestFormErrors');
        var btn = document.getElementById('contestSubmitBtn');
        var spinner = document.getElementById('contestSubmitSpinner');
        try {
          var container = document.getElementById('contestForm');
          var action = container.getAttribute('data-action');
          var method = container.getAttribute('data-method') || 'POST';
          errorsDiv.classList.add('d-none');
          errorsDiv.innerHTML = '';
          btn.disabled = true;
          spinner.classList.remove('d-none');
          var formData = new FormData();
          formData.append('_token', '{{ csrf_token() }}');
          formData.append('title', document.getElementById('contest_title_input').value);
          formData.append('text', document.getElementById('contest_text_input').value);
          formData.append('draw_date', document.getElementById('contest_draw_date_input').value);
          formData.append('num_winners', document.getElementById('contest_num_winners_input').value);
          if (method === 'PUT') { formData.append('_method', 'PUT'); }
          fetch(action, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData,
          })
            .then(function (response) {
              btn.disabled = false;
              spinner.classList.add('d-none');
              if (response.ok) {
                response.json().then(function (data) {
                  if (data.success) { window.location.reload(); }
                  else { errorsDiv.innerHTML = data.message || 'Error.'; errorsDiv.classList.remove('d-none'); }
                }).catch(function () { window.location.reload(); });
              } else if (response.status === 422) {
                response.json().then(function (data) {
                  var msgs = [];
                  if (data.errors) { Object.values(data.errors).forEach(function (e) { msgs = msgs.concat(e); }); }
                  errorsDiv.innerHTML = msgs.join('<br>');
                  errorsDiv.classList.remove('d-none');
                }).catch(function () { errorsDiv.innerHTML = 'Validation error.'; errorsDiv.classList.remove('d-none'); });
              } else {
                errorsDiv.innerHTML = 'An error occurred (HTTP ' + response.status + ').';
                errorsDiv.classList.remove('d-none');
              }
            })
            .catch(function (err) {
              btn.disabled = false;
              spinner.classList.add('d-none');
              errorsDiv.innerHTML = 'Network error. Please try again.';
              errorsDiv.classList.remove('d-none');
            });
        } catch (e) {
          btn.disabled = false;
          spinner.classList.add('d-none');
          errorsDiv.innerHTML = 'Error: ' + e.message;
          errorsDiv.classList.remove('d-none');
        }
      }

      function editContest(id, data) {
        var container = document.getElementById('contestForm');
        container.setAttribute('data-action', '/contests/' + id);
        container.setAttribute('data-method', 'PUT');
        document.getElementById('contest_title_input').value = data.title || '';
        document.getElementById('contest_text_input').value = data.text || '';
        document.getElementById('contest_draw_date_input').value = data.draw_date || '';
        document.getElementById('contest_num_winners_input').value = data.num_winners || 1;
        document.getElementById('contestFormTitle').innerHTML = '<i class="fa-solid fa-edit me-1"></i> {{ __("messages.contest.edit_contest") }}';
        document.getElementById('contestCancelBtn').classList.remove('d-none');
        document.getElementById('contestFormCard').scrollIntoView({ behavior: 'smooth' });
      }

      function cancelEditContest() {
        var container = document.getElementById('contestForm');
        container.setAttribute('data-action', '{{ route('contests.store', $redirectLink->id) }}');
        container.setAttribute('data-method', 'POST');
        document.getElementById('contest_title_input').value = '';
        document.getElementById('contest_text_input').value = '';
        document.getElementById('contest_draw_date_input').value = '';
        document.getElementById('contest_num_winners_input').value = '1';
        document.getElementById('contestFormTitle').innerHTML = '<i class="fa-solid fa-plus me-1"></i> {{ __("messages.contest.add_contest") }}';
        document.getElementById('contestCancelBtn').classList.add('d-none');
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
  @endif

  <div class="mb-4 mt-4">
    @if (!$isDisabled)
      {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
    @endif
    <a href="{{ route('redirect-links.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
  </div>

  @if (auth()->user()->hasRole('super_admin') && isset($redirectLink) && $redirectLink->histories->isNotEmpty())
    {{-- History Section - Only for Super Admin --}}
    <div class="col-12">
      <div class="mb-5">
        <h4>{{ __('messages.redirect_links.history.title') }}</h4>
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>{{ __('messages.redirect_links.history.action') }}</th>
                <th>{{ __('messages.common.description') }}</th>
                <th>{{ __('messages.redirect_links.history.old_value') }}</th>
                <th>{{ __('messages.redirect_links.history.new_value') }}</th>
                <th>{{ __('messages.redirect_links.history.changed_by') }}</th>
                <th>{{ __('messages.redirect_links.history.changed_at') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($redirectLink->histories as $history)
                <tr>
                  <td>
                    <span class="badge bg-info">
                      {{ __('messages.redirect_links.history.actions.' . $history->action) }}
                    </span>
                  </td>
                  <td>{{ $history->description ?? '-' }}</td>
                  <td>{{ $history->old_value ?? '-' }}</td>
                  <td>{{ $history->new_value ?? '-' }}</td>
                  <td>{{ $history->getChangedByDisplayName() }}</td>
                  <td>{{ $history->created_at->translatedFormat('Y-m-d h:i a') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @endif



</div>

{{-- Quick Create User Modal --}}
@if(!$isDisabled && (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('sales')))
  <div class="modal fade" id="createQuickUserModal" tabindex="-1" aria-labelledby="createQuickUserModalLabel"
    aria-modal="true" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content" @if(getLogInUser()->language == 'ar') dir="rtl" @endif>
        <div class="modal-header">
          <h5 class="modal-title" id="createQuickUserModalLabel">
            {{ __('messages.redirect_links.quick_user.create_new_user') }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="quickUserErrors" class="alert alert-danger d-none"></div>
          <div class="mb-3">
            <label for="quick_first_name" class="form-label required">{{ __('messages.user.first_name') }}</label>
            <input type="text" class="form-control" id="quick_first_name"
              placeholder="{{ __('messages.user.first_name') }}">
          </div>
          <div class="mb-3">
            <label for="quick_last_name" class="form-label required">{{ __('messages.user.last_name') }}</label>
            <input type="text" class="form-control" id="quick_last_name"
              placeholder="{{ __('messages.user.last_name') }}">
          </div>
          <div class="mb-3">
            <label for="quick_phone"
              class="form-label required">{{ __('messages.redirect_links.quick_user.phone') }}</label>
            <input type="tel" id="quick_phone" class="form-control" placeholder="962 XXX XXXX" pattern="^(962)[1-9]\d{8}$"
              title="يرجى إدخال رقم هاتف أردني صالح يبدأ بـ 962 غير متبوع ب 0"
              style="padding: 8px 13px; padding-left: 50px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease; background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDJDMTMuMSAyIDE0IDIuOSAxNCA0VjE2QzE0IDE3LjEgMTMuMSAxOCA5IDE4VjE2QzQuOSAxNiA0IDE1LjEgNCAxNFY0QzQgMi45IDQuOSAyIDYgMkgxOFoiIGZpbGw9IiM2MzY2RjEiLz4KPHN2ZyB4PSI2IiB5PSI2IiB3aWR0aD0iMTIiIGhlaWdodD0iMTIiIHZpZXdCb3g9IjAgMCAxMiAxMiIgZmlsbD0ibm9uZSI+Cjx0ZXh0IHg9IjAiIHk9IjEwIiBmb250LXNpemU9IjEwIiBmaWxsPSIjNjM2NkYxIj5KTzwvdGV4dD4KPHN2Zz4KPHN2Zz4K'); background-repeat: no-repeat; background-position: 10px center;">
            <small class="text-muted">يرجى إدخال رقم أردني يبدأ بـ 962 (مثال: 962799123456)</small>
            <div id="quick_phone_error" class="invalid-feedback"></div>
          </div>
        </div>
        <div class="modal-footer pt-0">
          <button type="button" class="btn btn-primary" id="saveQuickUserBtn">
            <span id="saveQuickUserSpinner" class="spinner-border spinner-border-sm d-none me-1" role="status"></span>
            {{ __('messages.common.save') }}
          </button>
          <button type="button" class="btn btn-secondary"
            data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Track unsaved changes
      let formChanged = false;

      // Prevent Enter key in quick-create modal from submitting the parent form
      (function () {
        const quickUserModal = document.getElementById('createQuickUserModal');
        if (!quickUserModal) {
          return;
        }

        // Handler to prevent Enter from submitting when modal is open
        function preventEnterSubmit(e) {
          if (e.key === 'Enter') {
            if (e.target && e.target.tagName && e.target.tagName.toLowerCase() !== 'textarea') {
              e.preventDefault();
              e.stopPropagation();
            }
          }
        }

        // Attach listener when modal is shown, remove when hidden
        quickUserModal.addEventListener('shown.bs.modal', function () {
          quickUserModal.addEventListener('keydown', preventEnterSubmit);
        });
        quickUserModal.addEventListener('hidden.bs.modal', function () {
          quickUserModal.removeEventListener('keydown', preventEnterSubmit);
        });

        // Also attach to inputs inside modal as a fallback
        const inputs = quickUserModal.querySelectorAll('input, select, button');
        inputs.forEach(function (input) {
          input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && e.target.tagName.toLowerCase() !== 'textarea') {
              e.preventDefault();
            }
          });
        });
      })();
      const mainForm = document.getElementById('redirectLinkEditForm');
      if (mainForm) {
        mainForm.addEventListener('change', function () { formChanged = true; });
        mainForm.addEventListener('input', function () { formChanged = true; });
        mainForm.addEventListener('submit', function () { formChanged = false; });
      }

      window.addEventListener('beforeunload', function (e) {
        if (formChanged) {
          e.preventDefault();
          e.returnValue = '{{ __("messages.redirect_links.quick_user.unsaved_changes") }}';
          return e.returnValue;
        }
      });

      // Quick user creation AJAX
      const saveBtn = document.getElementById('saveQuickUserBtn');
      if (saveBtn) {
        saveBtn.addEventListener('click', function () {
          const firstName = document.getElementById('quick_first_name').value.trim();
          const lastName = document.getElementById('quick_last_name').value.trim();
          const phone = document.getElementById('quick_phone').value.trim();
          const errorsDiv = document.getElementById('quickUserErrors');
          const spinner = document.getElementById('saveQuickUserSpinner');

          errorsDiv.classList.add('d-none');
          errorsDiv.textContent = '';

          if (!firstName || !lastName || !phone) {
            errorsDiv.textContent = '{{ __("messages.redirect_links.quick_user.fill_all_fields") }}';
            errorsDiv.classList.remove('d-none');
            return;
          }

          // Validate phone format (Jordanian: starts with 962, 12 digits total)
          const phonePattern = /^(962)[1-9]\d{8}$/;
          if (!phonePattern.test(phone)) {
            errorsDiv.textContent = 'يرجى إدخال رقم هاتف أردني صالح يبدأ بـ 962 غير متبوع ب 0 (مثال: 962799123456)';
            errorsDiv.classList.remove('d-none');
            return;
          }

          saveBtn.disabled = true;
          spinner.classList.remove('d-none');

          fetch('{{ route("redirect-links.create-quick-user") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
            },
            body: JSON.stringify({
              first_name: firstName,
              last_name: lastName,
              contact: phone,
            }),
          })
            .then(response => response.json())
            .then(data => {
              saveBtn.disabled = false;
              spinner.classList.add('d-none');

              if (data.success) {
                const select = document.getElementById('user_id_select');
                const hiddenInput = document.getElementById('user_id_hidden');

                // Add the new user as an option and select it
                const newOption = new Option(data.user.full_name, data.user.id, true, true);
                select.appendChild(newOption);
                select.value = data.user.id;

                // For sales: also update the hidden input so the value is submitted
                if (hiddenInput) {
                  hiddenInput.value = data.user.id;
                }

                formChanged = true;

                // Close the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('createQuickUserModal'));
                modal.hide();

                // Clear the form
                document.getElementById('quick_first_name').value = '';
                document.getElementById('quick_last_name').value = '';
                document.getElementById('quick_phone').value = '';

                // Navigate to WhatsApp
                const loginUrl = '{{ route("login") }}';
                const whatsappMessage = encodeURIComponent(
                  'عزيزي، ' + data.user.full_name + '\n\n' +
                  'يمكنك الدخول للوحة التحكم عبر الرابط\n\n' +
                  loginUrl + '\n\n' +
                  'اسم الدخول ' + data.user.contact + '\n\n' +
                  'الباسوورد ' + data.user.password + '\n\n'
                );
                const whatsappUrl = 'https://wa.me/' + data.user.contact + '?text=' + whatsappMessage;
                window.open(whatsappUrl, '_blank');

              } else {
                errorsDiv.textContent = data.message || '{{ __("messages.redirect_links.quick_user.creation_failed") }}';
                errorsDiv.classList.remove('d-none');
              }
            })
            .catch(error => {
              saveBtn.disabled = false;
              spinner.classList.add('d-none');
              errorsDiv.textContent = '{{ __("messages.redirect_links.quick_user.creation_failed") }}';
              errorsDiv.classList.remove('d-none');
              console.error('Error:', error);
            });
        });
      }
    });
  </script>
@endif