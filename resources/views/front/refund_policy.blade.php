@extends(homePageLayout())
@section('title')
    {{ __('messages.vcard.refund_cancellation_policy') }}
@endsection
@section('content')
    <section class="@if(getSuperAdminSettingValue('home_page_theme') == 3 || getSuperAdminSettingValue('home_page_theme') == 4) mt-4 mb-4 @else top-margin-privacy @endif">
        <div class="@if(getSuperAdminSettingValue('home_page_theme') == 4) mx-auto px-4 prose max-w-7xl @else container p-t-100 padding-top-0 @if(getSuperAdminSettingValue('home_page_theme') == 3) prose max-w-7xl @endif @endif">
            <div class="@if(getSuperAdminSettingValue('home_page_theme') == 4) mt-24 px-2 @else mt-100 px-2 @endif">{!! $setting['refund_cancellation'] !!}</div>
        </div>
    </section>
@endsection
