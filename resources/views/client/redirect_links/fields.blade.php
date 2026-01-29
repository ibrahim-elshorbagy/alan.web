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
  <div class="col-lg-6">
    <div class="">
      <label class="form-label">{{ __('messages.redirect_links.redirect_link_type') }}:</label>
      <p class="form-control-plaintext">
        {{ isset($redirectLink) ? \App\Enums\RedirectLinkTypeEnum::from($redirectLink->redirect_link_type)->label() : '' }}
      </p>
    </div>
  </div>
  @if (isset($redirectLink) && $redirectLink->redirect_link_type == 1)
    <div class="col-12 mb-4">
      <small class="text-muted">{!! nl2br(__('messages.redirect_links.website_redirect_note')) !!}</small>
    </div>
  @endif
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('redirect_link', __('messages.redirect_links.redirect_link') . ':', ['class' => 'form-label']) }}
      {{ Form::text('redirect_link', isset($redirectLink) ? $redirectLink->redirect_link : null, ['class' => 'form-control', 'placeholder' => __('messages.redirect_links.redirect_link'), 'disabled' => isset($redirectLink) && $redirectLink->status == 2]) }}
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
    <a href="{{ route('client.redirect-links.index') }}"
      class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
  </div>
</div>
