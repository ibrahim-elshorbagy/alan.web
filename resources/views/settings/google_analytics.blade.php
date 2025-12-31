@extends('settings.edit')
@section('section')
  <div class="card w-100">
    <div class="card-body d-md-flex">
      @include('settings.setting_menu')
      <div class=" w-100">
        <div class="card-header px-0">
          <div class="d-flex align-items-center justify-content-center">
            <h3 class="m-0">{{ __('messages.plan.seo') }}
            </h3>
          </div>
        </div>
        {{ Form::open(['route' => ['google_analytics.update'], 'method' => 'post', 'class' => 'border-top']) }}
        <div class="row pt-4">
          <div class="col-lg-6 mb-3">
            {{ Form::label('Site title', __('messages.vcard.site_title') . ':', ['class' => 'form-label']) }}
            {{ Form::text('site_title', isset($metas) ? $metas['site_title'] : null, ['class' => 'form-control', 'placeholder' => __('messages.form.site_title')]) }}
          </div>
          <div class="col-lg-6 mb-3">
            {{ Form::label('Home title', __('messages.vcard.home_title') . ':', ['class' => 'form-label']) }}
            {{ Form::text('home_title', isset($metas) ? $metas['home_title'] : null, ['class' => 'form-control', 'placeholder' => __('messages.form.home_title')]) }}
          </div>
          <div class="col-lg-6 mb-3">
            {{ Form::label('Meta keyword', __('messages.vcard.meta_keyword') . ':', ['class' => 'form-label']) }}
            {{ Form::text('meta_keyword', isset($metas) ? $metas['meta_keyword'] : null, ['class' => 'form-control', 'placeholder' => __('messages.form.meta_keyword')]) }}
          </div>
          <div class="col-lg-6 mb-3">
            {{ Form::label('Meta Description', __('messages.vcard.meta_description') . ':', ['class' => 'form-label']) }}
            {{ Form::text('meta_description', isset($metas) ? $metas['meta_description'] : null, ['class' => 'form-control', 'placeholder' => __('messages.form.meta_description')]) }}
          </div>
        </div>
        <div class="card-header px-0 py-3">
          <div class="d-flex align-items-center justify-content-center">
            <h3 class="m-0">{{ __('messages.vcard.google_analytics') }}
            </h3>
          </div>
        </div>
        <div class="col-lg-12 border-top pt-4 mb-3">
          {{ Form::label('Google Analytics', __('messages.vcard.google_analytics') . ':', ['class' => 'form-label']) }}
          {{ Form::textarea('google_analytics', isset($metas) ? $metas['google_analytics'] : null, ['class' => 'form-control', 'placeholder' => __('messages.form.google_analytics')]) }}
        </div>
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
        {{ Form::close() }}

        {{-- Sitemap Section --}}
        <div class="card-header px-0 py-3 mt-4">
          <div class="d-flex align-items-center justify-content-center">
            <h3 class="m-0">{{ __('messages.sitemap.sitemap') }}</h3>
          </div>
        </div>
        <div class="border-top pt-4">
          <div class="row">
            <div class="col-lg-12 mb-3">
              <label class="form-label">{{ __('messages.sitemap.sitemap_url') }}:</label>
              <div class="input-group">
                <input type="text" class="form-control" id="sitemapUrl" value="{{ config('app.url') }}/sitemap.xml"
                  readonly>
                <a href="{{ config('app.url') }}/sitemap.xml" target="_blank" class="btn btn-outline-primary">
                  <i class="fas fa-external-link-alt"></i> {{ __('messages.sitemap.view_sitemap') }}
                </a>
              </div>
            </div>
            <div class="col-lg-12 mb-3">
              @php
                $sitemapGeneratedAt = \App\Models\Setting::where('key', 'sitemap_generated_at')->first();
              @endphp
              @if ($sitemapGeneratedAt && $sitemapGeneratedAt->value)
                <p class="text-muted mb-2">
                  <i class="fas fa-clock"></i>
                  {{ __('messages.sitemap.last_generated') }}:
                  <strong>{{ \Carbon\Carbon::parse($sitemapGeneratedAt->value)->format('Y-m-d H:i:s') }}</strong>
                </p>
              @endif
              <p class="text-muted small">
                {{ __('messages.sitemap.sitemap_description') }}
              </p>
            </div>
            <div class="col-lg-12">
              <a href="{{ route('generateSitemap') }}" class="btn btn-success" id="regenerateSitemapBtn">
                <i class="fas fa-sync-alt"></i> {{ __('messages.sitemap.regenerate_sitemap') }}
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
