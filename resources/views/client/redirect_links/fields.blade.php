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
    <a href="https://wa.me/{{ $assignedUser->contact }}" class="text-success" target="_blank"><i class="fab fa-whatsapp fa-sm"></i> {{ $assignedUser->contact }}</a>
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
      <a href="#" class="list-group-item list-group-item-action" onclick="event.preventDefault(); document.getElementById('redirect_link').value = '{{ route('vcard.show', ['alias' => $vcard->url_alias]) }}';">
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
@if (isset($redirectLink) && $redirectLink->status == 2)
<div class="col-12">
  <div class="alert alert-danger">
    <strong>{{ __('messages.redirect_links.rejected_note') }}</strong>
  </div>
</div>
@endif
<div>
  @if (!isset($redirectLink) || $redirectLink->status != 2)
  {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
  @endif
  <a href="{{ route('client.redirect-links.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
</div>
</div>
