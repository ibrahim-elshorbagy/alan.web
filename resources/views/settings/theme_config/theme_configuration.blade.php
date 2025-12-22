<div class="row">
    <div class="col-12">
        <h2 class="mb-5">{{ __('messages.vcard.theme_config') }}</h2>
    </div>
</div>
<div class="row">
     <div class="col-12 col-md-6">
         <div class="form-group mb-7">
             <input type="hidden" name="theme_id" value="{{ $setting['home_page_theme'] }}" id="themeInput">
             <div class="theme-img-radio img-thumbnail  {{ $setting['home_page_theme'] == 1 ? 'img-border' : '' }}"
                 data-id="1">
                 <img src="{{ asset('assets/img/theme1.png') }}" alt="Template">
             </div>
         </div>
     </div>
     <div class="col-12 col-md-6">
         <div class="form-group mb-7 ">
             <div class="theme-img-radio img-thumbnail {{ $setting['home_page_theme'] == 2 ? 'img-border' : '' }}"
                 data-id="2">
                 <img src="{{ asset('assets/img/theme2.png') }}" alt="Template">
             </div>
         </div>
     </div>
     <div class="col-12 col-md-6">
        <div class="form-group mb-7 ">
            <div class="theme-img-radio img-thumbnail {{ $setting['home_page_theme'] == 3 ? 'img-border' : '' }}"
                data-id="3">
                <img src="{{ asset('assets/img/theme3.png') }}" alt="Template">
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group mb-7 ">
            <div class="theme-img-radio img-thumbnail {{ $setting['home_page_theme'] == 4 ? 'img-border' : '' }}"
                data-id="4">
                <img src="{{ asset('assets/img/theme4.png') }}" alt="Template">
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row mt-10">
    <div class="col-12">
        <h2 class="mb-5">{{ __('messages.vcard.auth_theme_configuration') }}</h2>
    </div>
</div>
<div class="row">
     <div class="col-12 col-md-6">
         <div class="form-group mb-7">
             <input type="hidden" name="auth_theme_id" value="{{ $setting['auth_page_theme'] }}" id="authThemeInput">
             <div class="auth-theme-img-radio img-thumbnail  {{ $setting['auth_page_theme'] == 1 ? 'img-border' : '' }}"
                 data-id="1">
                 <img src="{{ asset('assets/img/auth_theme_1.png') }}" alt="Template">
             </div>
         </div>
     </div>
     <div class="col-12 col-md-6">
         <div class="form-group mb-7 ">
             <div class="auth-theme-img-radio img-thumbnail {{ $setting['auth_page_theme'] == 2 ? 'img-border' : '' }}"
                 data-id="2">
                 <img src="{{ asset('assets/img/auth_theme_2.png') }}" alt="Template">
             </div>
         </div>
     </div>
</div>

<div class="col-lg-12 mt-2 d-flex">
     <button class="btn btn-primary me-3 ">
         {{ __('messages.common.save') }}
     </button>
</div>
