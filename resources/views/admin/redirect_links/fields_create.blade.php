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
      {{ Form::select('nfcs_id', $nfcs->pluck('name', 'id'), null, ['class' => 'form-control', 'required']) }}
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('number_of_cards', __('messages.redirect_links.number_of_cards') . ':', ['class' => 'form-label required']) }}
      {{ Form::number('number_of_cards', 1, ['class' => 'form-control', 'required', 'min' => 1, 'max' => 100]) }}
    </div>
  </div>
  <div>
    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
    <a href="{{ route('redirect-links.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
  </div>
</div>
