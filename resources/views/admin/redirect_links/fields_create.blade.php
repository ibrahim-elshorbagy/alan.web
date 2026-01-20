<div class="row">
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('redirect_link_type', __('messages.redirect_links.redirect_link_type') . ':', ['class' => 'form-label required']) }}
      {{ Form::select('redirect_link_type', collect(\App\Enums\RedirectLinkTypeEnum::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])->toArray(), null, ['class' => 'form-control', 'required']) }}
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('nfcs_id', __('messages.redirect_links.nfc') . ':', ['class' => 'form-label required']) }}
      {{ Form::select('nfcs_id', $nfcs->pluck('name', 'id'), null, ['class' => 'form-control', 'required', 'id' => 'nfcsSelect']) }}
      <div id="nfcPriceInfo" class="mt-2 text-muted" style="display: none;">
        <small>
          <strong>{{ __('messages.admin_price') }}:</strong> <span id="nfcPrice"></span><br>
          <strong>{{ __('messages.common.sales_price') }}:</strong> <span id="nfcSalesPrice"></span>
        </small>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('number_of_cards', __('messages.redirect_links.number_of_cards') . ':', ['class' => 'form-label required']) }}
      {{ Form::number('number_of_cards', 1, ['class' => 'form-control', 'required', 'min' => 1, 'max' => 100]) }}
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('assigned_id', __('messages.redirect_links.assigned_to') . ':', ['class' => 'form-label']) }}
      {{ Form::select('assigned_id', ['' => __('messages.common.select_sales')] + $salesUsers->mapWithKeys(fn($user) => [$user->id => $user->first_name . ' ' . $user->last_name])->toArray(), null, ['class' => 'form-control']) }}
    </div>
  </div>
  <div>
    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
    <a href="{{ route('redirect-links.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
  </div>
</div>
