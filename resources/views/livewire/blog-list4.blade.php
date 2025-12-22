<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        @foreach ($blogs as $blog)
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 overflow-hidden group">
                <a href="{{ route('fornt-blog-show', $blog->slug) }}" class="block">
                    <div class="relative overflow-hidden">
                        <div class="aspect-w-16 aspect-h-9">
                            <img src="{{ isset($blog->blog_image) ? $blog->blog_image : asset('front/images/about-1.png') }}"
                                alt="Blog post"
                                class="h-[240px] w-full object-cover transition-transform duration-300 group-hover:scale-110" />
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                </a>

                <div class="p-8">

                    @php
                        $description = $blog->description;
                        $wordCount = str_word_count(strip_tags($description));
                    @endphp

                    <a href="{{ route('fornt-blog-show', $blog->slug) }}" class="group">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors duration-200 leading-tight">
                            {{ $blog->title }}
                        </h3>
                    </a>

                    @if ($wordCount > 35)
                        <p class="text-gray-600 mb-6 line-clamp-3 leading-relaxed">
                            {!! str_replace('&nbsp;', ' ', \Illuminate\Support\Str::words(strip_tags($description), 35, '...')) !!}
                        </p>
                    @else
                        <p class="text-gray-600 mb-6 line-clamp-3 leading-relaxed">{!! str_replace('&nbsp;', ' ', $description) !!}</p>
                    @endif

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="bx bx-calendar mr-2 text-blue-500"></i>
                            <span>{{ $blog->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="bx bx-time mr-2 text-purple-500"></i>
                            <span>{{ $blog->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('fornt-blog-show', $blog->slug) }}"
                           class="inline-flex items-center text-blue-600 font-medium hover:text-blue-700 transition-colors group">
                            {{ __('messages.vcard_11.read_more') }}
                            <i class='bx bx-right-arrow-alt ml-2 transition-transform group-hover:translate-x-1 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-0 mr-2 group-hover:-translate-x-1 @endif'></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-12" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="bg-white">
            {{ $blogs->links() }}
        </div>
    </div>
</div>
