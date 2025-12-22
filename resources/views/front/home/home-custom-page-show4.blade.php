@extends('front.layouts.app4')
    @if ($customPage['seo_title'])
        <title>{{ $customPage['seo_title'] }} | {{ getAppName() }}</title>
    @else
        <title> {{ $customPage['title'] }} | {{ getAppName() }}</title>
    @endif
@section('content')
    <!-- Custom Page Header -->
    <header class="pt-20 pb-16 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 relative overflow-hidden"
        @if (checkFrontLanguageSession() == 'ar') dir="rtl" @endif>
        <div class="absolute top-0 left-0 w-64 h-64 bg-blue-100 rounded-full blur-3xl opacity-30" style="margin-left:-3rem;margin-top:-3rem;"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-purple-100 rounded-full blur-3xl opacity-30" style="margin-right:-3rem;margin-bottom:-3rem;"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="flex justify-center">
                <div class="w-full lg:w-3/4 xl:w-2/3 mx-auto">
                    <div class="custom-content ql-editor">
                        {!! $customPage->description !!}
                    </div>
                </div>
            </div>
        </div>
    </header>

    <style>
        .custom-content {
            background-color: transparent !important;
            background: transparent !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch Bootstrap CSS
            fetch('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css')
                .then(response => response.text())
                .then(css => {
                    // Create scoped CSS by adding .custom-content prefix
                    const scopedCSS = css.replace(/([^{}]+){/g, function(match, selectors) {
                        // Skip @media, @keyframes, @font-face etc.
                        if (selectors.trim().startsWith('@')) {
                            return match;
                        }

                        // Split multiple selectors
                        const selectorList = selectors.split(',');
                        const scopedSelectors = selectorList.map(selector => {
                            const trimmedSelector = selector.trim();

                            // Skip empty selectors
                            if (!trimmedSelector) return selector;

                            // Skip :root and html selectors
                            if (trimmedSelector === ':root' || trimmedSelector === 'html' || trimmedSelector === 'body') {
                                return `.custom-content`;
                            }

                            // Add scope prefix
                            return `.custom-content ${trimmedSelector}`;
                        });

                        return scopedSelectors.join(', ') + '{';
                    });

                    // Create and inject the scoped stylesheet
                    const styleSheet = document.createElement('style');
                    styleSheet.textContent = scopedCSS;
                    document.head.appendChild(styleSheet);

                    // Load Bootstrap JavaScript
                    const script = document.createElement('script');
                    script.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js';
                    document.head.appendChild(script);
                })
        });
    </script>
@endsection
