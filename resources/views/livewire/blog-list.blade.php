<div>
    <div class="row pt-3 pt-lg-0">
        @foreach ($blogs as $blog)
            <div class="col-12 margin-b-80px mt-4">
                <div class="row mt-5 ">
                    <div class="col-xl-5 col-lg-5 position-relative ">
                        <a href="{{ route('fornt-blog-show', $blog->slug) }}">
                            <div class="blog-img">
                                <img src="{{ isset($blog->blog_image) ? $blog->blog_image : asset('front/images/about-1.png') }}"
                                    alt="About" class="h-auto w-100 image-object-fit-cover" />
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-7 col-lg-7">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <div class="about-content mt-4 mt-lg-0">
                                <div class="d-flex align-items-center flex-wrap">
                                    <div>
                                        <a class="text-decoration-none text-black"
                                            href="{{ route('fornt-blog-show', $blog->slug) }}">
                                            <h4 class="w-100 mb-3 mt-3"> {{ $blog->title }}</h4>
                                        </a>
                                        @php
                                            $description = $blog->description;
                                            $wordCount = str_word_count(strip_tags($description));
                                        @endphp
                                        @if ($wordCount > 35)
                                            <p class="text-gray-100 fs-18 mb-0">
                                                {{ \Illuminate\Support\Str::words(strip_tags($description), 35, '...') }}
                                            </p>
                                        @else
                                            <p class="text-gray-100 fs-18 mb-0">{!! $description !!}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-gray-100 fs-18 date-time">
                                <span><i class="fas fa-calendar-alt icon-color-bs-purple"></i><span
                                        class="ms-2">{{ $blog->created_at->format('F d, Y') }}</span></span> <span
                                    class="text-primary ms-4 me-4">|</span>
                                <span> <i class="fas fa-clock icon-color-bs-purple"></i> <span
                                        class="ms-2">{{ $blog->created_at->diffForHumans() }} </span> </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $blogs->links() }}
    </div>
</div>
