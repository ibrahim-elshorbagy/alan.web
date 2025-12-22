@extends('front.layouts.app3')
@section('title')
{{ __('messages.vcards_templates') }}
@endsection
@section('content')
    <section class="pt-12 pb-12 bg-gradient-to-br from-secondary-900 to-secondary-800 text-white"
        @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h1
                    class="text-4xl md:text-5xl font-bold mb-1 bg-gradient-to-r from-primary-400 via-accent-400 to-white bg-clip-text text-transparent blog-title">
                    {{ __('messages.vcards_templates') }}</h1>
            </div>
        </div>
        <!-- Decorative shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-primary-500/10 rounded-full filter blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-accent-500/10 rounded-full filter blur-3xl"></div>
        </div>
    </section>
    @php
        $TEMPLATE_NAME = [
            1 => 'Simple_Contact',
            2 => 'Executive_Profile',
            3 => 'Clean_Canvas',
            4 => 'Professional',
            5 => 'Corporate_Connect',
            6 => 'Modern_Edge',
            7 => 'Business_Beacon',
            8 => 'Corporate_Classic',
            9 => 'Corporate_Identity',
            10 => 'Pro_Network',
            11 => 'Portfolio',
            12 => 'Gym',
            13 => 'Hospital',
            14 => 'Event_Management',
            15 => 'Salon',
            16 => 'Lawyer',
            17 => 'Programmer',
            18 => 'CEO/CXO',
            19 => 'Fashion_Beauty',
            20 => 'Culinary_Food_Services',
            21 => 'Social_Media',
            22 => 'Dynamic_vcard',
            23 => 'Consulting_Services',
            24 => 'School_Templates',
            25 => 'Social_Services',
            26 => 'Retail_E-commerce',
            27 => 'Pet_Shop',
            28 => 'Pet_Clinic',
            29 => 'Marriage',
            30 => 'Taxi_Service',
            31 => 'Handyman_Services',
            32 => 'Interior_Designer',
            33 => 'Musician_Templates',
            34 => 'Photographer',
            35 => 'Real_Estate',
            36 => 'Travel_Agency',
            37 => 'Flower_Garden',
            38 => 'Architecture',
            65 => 'Reporter',
        ];
    @endphp
    <div class="vcard-template-section pt-20 pb-5 position-relative" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="container">
            <div class="row">
                @foreach (getTemplateUrls() as $id => $url)
                @isset($TEMPLATE_NAME[$id])
                    <div class="col-lg-4 col-sm-6 mb-20">
                        <div
                            class="template-card h-100 @if ($id == 22) ribbon-box position-relative @endif">
                            <div class="card-img">
                                <img src="{{ $url }}" class="w-100 img-fluid">
                            </div>
                            @if ($id == 22)
                                <div class="ribbon-wrapper">
                                    <div class="ribbon fw-bold">{{ __('messages.feature.dynamic_vcard') }}</div>
                                </div>
                            @endif
                            <div class="card-body p-0 pt-4 mt-1">
                                <h6 class="fs-20 text-center fw-600">{{ __('messages.' . $TEMPLATE_NAME[$id]) }}</h6>
                            </div>
                        </div>
                    </div>
                @endisset
                @endforeach
            </div>
        </div>
    </div>
@endsection
