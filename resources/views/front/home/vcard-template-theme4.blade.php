@extends('front.layouts.app4')
@section('title')
{{ __('messages.vcards_templates') }}
@endsection
@section('content')
    <section class="pt-20 pb-16 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50"
        @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h1
                        class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 mt-10 text-gray-900 leading-tight">
                    {{ __('messages.vcards_templates') }}</h1>
            </div>
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
    <div class="vcard-template-section pt-20 pb-5 relative" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-3">
                @foreach (getTemplateUrls() as $id => $url)
                @isset($TEMPLATE_NAME[$id])
                    <div class="lg:w-1/3 sm:w-1/2 w-full px-3 mb-20">
                        <div
                            class="h-full @if ($id == 22) relative @endif template-card">
                            <div class="card-img">
                                <img src="{{ $url }}" class="w-full">
                            </div>
                            @if ($id == 22)
                                <div class="ribbon-wrapper">
                                    <div class="ribbon font-bold">{{ __('messages.feature.dynamic_vcard') }}</div>
                                </div>
                            @endif
                            <div class="p-0 pt-4 mt-1">
                                <h6 class="text-xl text-center font-bold">{{ __('messages.' . $TEMPLATE_NAME[$id]) }}</h6>
                            </div>
                        </div>
                    </div>
                    @endisset
                @endforeach
            </div>
        </div>
    </div>
@endsection
