<div class="row">
    <div class="col-md-6">
        <div class="mb-5">
            {{ Form::label('title', __('messages.blog.title') . ':', ['class' => 'form-label required']) }}
            {{ Form::text('title', isset($customPage) ? $customPage->title : null, ['class' => 'form-control', 'placeholder' => __('messages.blog.title'), 'required', 'id' => 'customPageTitle', 'maxlength' => '30']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-5">
            {{ Form::label('slug', __('messages.blog.slug') . ':', ['class' => 'form-label required ']) }}
            {{ Form::text('slug', isset($customPage) ? $customPage->slug : null, ['class' => 'form-control', 'placeholder' => __('messages.blog.slug'), 'required', 'id' => 'customPageSlug']) }}
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-12">
        <div class="form-group mb-3">
            <div class="mb-5">
                {{ Form::label('description', __('messages.blog.description') . ':', ['class' => 'form-label required']) }}
                <div id="customPageDescriptionEditor" class="editor-height" style="height: 200px" data-turbo="false">
                    @isset($customPage)
                        {!! $customPage->description !!}
                    @endisset
                </div>
                {{ Form::Hidden('description', isset($customPage) ? $customPage->description : null, ['id' => 'customPageDescriptionData']) }}
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="mb-5">
            {{ Form::label('SEO Title', __('messages.blog.seo_title') . ':', ['class' => 'form-label required']) }}
            {{ Form::text('seo_title', isset($customPage) ? $customPage->seo_title : null, ['class' => 'form-control', 'placeholder' => __('messages.blog.seo_title')]) }}
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="mb-5">
            {{ Form::label('SEO keywords', __('messages.blog.seo_keywords') . ':', ['class' => 'form-label required']) }}
            {{ Form::text('seo_keyword', isset($customPage) ? $customPage->seo_keyword : null, ['class' => 'form-control', 'placeholder' => __('messages.blog.seo_keywords')]) }}
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="mb-5">
            {{ Form::label('SEO Description', __('messages.blog.seo_description') . ':', ['class' => 'form-label required']) }}
            {{ Form::text('seo_description', isset($customPage) ? $customPage->seo_description : null, ['class' => 'form-control', 'placeholder' => __('messages.blog.seo_description')]) }}
        </div>
    </div>
    <div>
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
        <a href="{{ route('custom.page.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>
</div>
