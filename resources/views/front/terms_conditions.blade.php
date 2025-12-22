@extends(homePageLayout())
@section('title')
    {!! __('messages.vcard.term_condition') !!}
@endsection
@section('content')
    <section class="@if(getSuperAdminSettingValue('home_page_theme') == 3 || getSuperAdminSettingValue('home_page_theme') == 4) mt-5 mb-4 @else top-margin @endif" >
        <div class="@if(getSuperAdminSettingValue('home_page_theme') == 4) mx-auto px-4 prose max-w-7xl @else container p-t-100 padding-top-0 @if(getSuperAdminSettingValue('home_page_theme') == 3) prose max-w-7xl @endif @endif">
            <div class="@if(getSuperAdminSettingValue('home_page_theme') == 4) mt-24 @else mt-100 @endif">{!! $setting['terms_conditions'] !!}</div>
        </div>
    </section>
@endsection
