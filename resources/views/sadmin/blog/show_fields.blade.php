<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="d-sm-flex align-items-center mb-5 mb-xxl-0 text-center text-sm-start">
                    <div class="image image-circle image-lg-small">
                        <img src="{{ $blog->blog_image }}" alt="user">
                    </div>
                    <div class="ms-0 ms-md-10 mt-5 mt-sm-0">
                        <h2>{{ $blog->title }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <label for="" class="form-label"> {{ __('messages.blog.description') . ':' }}</label>
            <span class="fs-4 text-gray-800">{!! $blog->description !!}</span>
        </div>
    </div>
</div>
