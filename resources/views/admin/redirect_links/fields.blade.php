@php
  $isDisabled = auth()->user()->hasRole('sales') && isset($redirectLink) && $redirectLink->status == 2;
@endphp
<div class="row">
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('user_id', __('messages.redirect_links.user') . ':', ['class' => 'form-label']) }}
      {{ Form::select('user_id', $users->mapWithKeys(fn($user) => [$user->id => $user->first_name . ' ' . $user->last_name])->toArray(), isset($redirectLink) ? $redirectLink->user_id : null, ['class' => 'form-control', 'placeholder' => __('messages.redirect_links.select_user'), 'disabled' => auth()->user()->hasRole('sales') || $isDisabled]) }}
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
      @if (isset($redirectLink) && $redirectLink->statusChangedBy)
        <small class="text-muted d-block mt-2">
          <i class="fas fa-user"></i> بواسطة: <strong>{{ $redirectLink->statusChangedBy->first_name }} {{ $redirectLink->statusChangedBy->last_name }}</strong>
          <br>
          <i class="fas fa-clock"></i> {{ __('messages.date') }}: <strong>{{$redirectLink->status_changed_at?->translatedFormat('Y-m-d h:i a') }}</strong>
        </small>
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
        {{ Form::label('sales_price', __('messages.selling_price') . ':', ['class' => 'form-label']) }}
        {{ Form::number('sales_price', isset($redirectLink) ? $redirectLink->sales_price : null, ['class' => 'form-control', 'placeholder' => __('messages.selling_price'), 'step' => '0.01', 'min' => '0', 'disabled' => $isDisabled]) }}
      </div>
    </div>
  @endif
  @if (!auth()->user()->hasRole('sales'))
    <div class="col-lg-6">
      <div class="mb-5">
        {{ Form::label('assigned_id', __('messages.redirect_links.assigned_to') . ':', ['class' => 'form-label']) }}
        {{ Form::select('assigned_id', ['' => __('messages.common.select_sales')] + $salesUsers->mapWithKeys(fn($user) => [$user->id => $user->first_name . ' ' . $user->last_name])->toArray(), isset($redirectLink) ? $redirectLink->assigned_id : null, ['class' => 'form-control', 'disabled' => $isDisabled]) }}
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
      @if (isset($redirectLink) && $redirectLink->receivedStatusChangedBy)
        <small class="text-muted d-block mt-2">
          <i class="fas fa-user"></i> بواسطة: <strong>{{ $redirectLink->receivedStatusChangedBy->first_name }} {{ $redirectLink->receivedStatusChangedBy->last_name }}</strong>
          <br>
          <i class="fas fa-clock"></i> {{ __('messages.date') }}: <strong>{{ $redirectLink->received_status_changed_at?->translatedFormat('Y-m-d h:i a') }}</strong>
        </small>
      @endif
    </div>
  </div>


  <div>
    @if (!$isDisabled)
      {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
    @endif
    <a href="{{ route('redirect-links.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
  </div>
</div>
