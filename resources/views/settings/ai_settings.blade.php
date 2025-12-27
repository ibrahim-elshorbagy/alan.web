@extends('settings.edit')
@section('section')
  <div class="card w-100">
    <div class="card-body d-md-flex">
      @include('settings.setting_menu')
      <div class="w-100">
        <div class="card-header px-0">
          <div class="d-flex align-items-center justify-content-center">
            <h3 class="m-0">{{ __('messages.vcard.open_ai') }}</h3>
          </div>
        </div>
        <div class="card-body border-top p-3">
          {{ Form::open(['route' => ['ai.setting.update'], 'method' => 'post', 'id' => 'aiSettings']) }}
          <div class="row mb-5 mt-10">
            <div class="row row-gap-24px">
              <div class="col-12">
                <div class="row">
                  <div class="col-12 d-flex align-items-center mb-5">
                    <span class="fs-3 me-3">{{ __('messages.vcard.open_ai') }}</span>
                    <label class="form-check form-switch form-check-solid form-switch-sm d-flex cursor-pointer">
                      <input type="checkbox" name="open_ai_enable" class="form-check-input" value="1"
                        {{ $setting['open_ai_enable'] ?? '0' == '1' ? 'checked' : '' }} id="openAiEnable">&nbsp;
                      <span class="form-check-label text-gray-600"
                        for="openAiEnable">{{ __('messages.enable') }}</span>&nbsp;&nbsp;
                      <span class="custom-switch-indicator"></span>
                    </label>
                  </div>

                  <div class="col-lg-6 mb-7" id="openAiSection"
                    style="{{ ($setting['open_ai_enable'] ?? '0') == '1' ? '' : 'display:none;' }}">
                    <div class="form-group mb-5">
                      {{ Form::label('openai_api_key', __('messages.vcard.open_ai_api_key') . ':', ['class' => 'form-label required']) }}
                      {{ Form::text('openai_api_key', $setting['openai_api_key'] ?? null, ['class' => 'form-control', 'id' => 'openAikey', 'placeholder' => __('messages.vcard.open_ai_api_key')]) }}
                    </div>
                  </div>

                  <div class="col-lg-6 mb-7" id="openAiModelSection"
                    style="{{ ($setting['open_ai_enable'] ?? '0') == '1' ? '' : 'display:none;' }}">
                    <div class="form-group mb-5">
                      {{ Form::label('open_ai_model', __('messages.vcard.open_ai_model') . ':', ['class' => 'form-label required']) }}
                      {{ Form::text('open_ai_model', $setting['open_ai_model'] ?? null, ['class' => 'form-control', 'id' => 'openAiModel', 'placeholder' => __('messages.vcard.open_ai_model'), 'style' => 'text-transform: lowercase;']) }}
                      <div class="form-text">{{ __('messages.vcard.open_ai_model_example') }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div>
            {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
            <a href="{{ route('setting.index', ['section' => 'ai_settings']) }}"
              class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const openAiEnable = document.getElementById('openAiEnable');
      const openAiSection = document.getElementById('openAiSection');
      const openAiModelSection = document.getElementById('openAiModelSection');
      const openAiModelInput = document.getElementById('openAiModel');

      if (openAiEnable) {
        openAiEnable.addEventListener('change', function() {
          if (this.checked) {
            openAiSection.style.display = '';
            openAiModelSection.style.display = '';
          } else {
            openAiSection.style.display = 'none';
            openAiModelSection.style.display = 'none';
          }
        });
      }

      // Auto-convert model name to lowercase
      if (openAiModelInput) {
        openAiModelInput.addEventListener('input', function() {
          this.value = this.value.toLowerCase();
        });
      }
    });
  </script>
@endsection
