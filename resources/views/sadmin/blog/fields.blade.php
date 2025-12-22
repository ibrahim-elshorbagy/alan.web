<div class="row">
    <div class="col-md-6">
        <div class="mb-5">
            {{ Form::label('title', __('messages.blog.title') . ':', ['class' => 'form-label required']) }}
            {{ Form::text('title', isset($blog) ? $blog->title : null, ['class' => 'form-control', 'placeholder' => __('messages.blog.title'), 'required', 'id' => 'blogTitle']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-5">
            {{ Form::label('slug', __('messages.blog.slug') . ':', ['class' => 'form-label required ']) }}
            {{ Form::text('slug', isset($blog) ? $blog->slug : null, ['class' => 'form-control', 'placeholder' => __('messages.blog.slug'), 'required', 'id' => 'blogSlug']) }}
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-12">
        <div class="form-group mb-3">
            <div class="mb-5">
                {{ Form::label('description', __('messages.blog.description') . ':', ['class' => 'form-label required']) }}
                <div id="blogDescriptionEditor" class="editor-height" style="height: 200px" data-turbo="false">
                    @isset($blog)
                        {!! $blog->description !!}
                    @endisset
                </div>
                {{ Form::Hidden('description', isset($blog) ? $blog->description : null, ['id' => 'blogDescriptionData']) }}
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-12">
        <div class="mb-5">
            <div class="mb-3" io-image-input="true">
                <label for="blogImage" class="form-label required">{{ __('messages.blog.image') . ':' }}</label>
                <span data-bs-toggle="tooltip" data-placement="top"
                    data-bs-original-title="{{ __('messages.tooltip.blog_img') }}">
                    <i class="fas fa-question-circle ml-1 general-question-mark"></i>
                </span>
                <div class="d-block">
                    <div class="image-picker">
                        <div class="image previewImage" id="blogImage"
                            style="background-image: url('{{ !empty($blog->blog_image) ? $blog->blog_image : asset('assets/images/default_cover_image.jpg') }}')">
                        </div>
                        <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                            data-placement="top" data-bs-original-title="{{ __('messages.blog.blog_image') }}">
                            <label>
                                <i class="fa-solid fa-pen" id="blogImageIcon"></i>
                                <input type="file" id="blog_image" name="blog_image"
                                    class="image-upload file-validation d-none crop-image-input" accept="image/*" data-crop-width="808" data-crop-height="480" data-preview-id="blogImagePreview"/>
                            </label>
                        </span>
                    </div>
                    <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="mb-5">
            {{ Form::label('SEO Title', __('messages.blog.seo_title') . ':', ['class' => 'form-label']) }}
            {{ Form::text('seo_title', isset($blog) ? $blog->seo_title : null, ['class' => 'form-control', 'placeholder' => __('messages.blog.seo_title')]) }}
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="mb-5">
            {{ Form::label('SEO keywords', __('messages.blog.seo_keywords') . ':', ['class' => 'form-label']) }}
            {{ Form::text('seo_keyword', isset($blog) ? $blog->seo_keyword : null, ['class' => 'form-control', 'placeholder' => __('messages.blog.seo_keywords')]) }}
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="mb-5">
            {{ Form::label('SEO Description', __('messages.blog.seo_description') . ':', ['class' => 'form-label']) }}
            {{ Form::text('seo_description', isset($blog) ? $blog->seo_description : null, ['class' => 'form-control', 'placeholder' => __('messages.blog.seo_description')]) }}
        </div>
    </div>
    <div>
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>
</div>
