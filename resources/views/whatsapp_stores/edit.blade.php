@extends('layouts.app')
@section('title')
  {{ __('messages.whatsapp_stores.whatsapp_stores') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-end mb-5">
      <h1>@yield('title')</h1>
      <a class="btn btn-outline-primary float-end"
        href="{{ route('whatsapp.stores') }}">{{ __('messages.common.back') }}</a>
    </div>
    <div class="col-12">
      @include('layouts.errors')
      @include('flash::message')

    </div>
    <div class="card">
      <div class="card-body d-sm-flex position-relative p-5">
        <div class="">
          <div class="">
            @include('whatsapp_stores.sub_menu')
          </div>
        </div>
        <div class="ps-sm-3 pt-lg-auto pt-0 w-100 overflow-auto px-1" id="main">
          <button type="button"
            class="btn px-0 aside-menu-container__aside-menubar d-block d-xl-none d-lg-none d-block edit-menu"
            onclick="openNav()">
            <i class="fa-solid fa-bars fs-1"></i>
          </button>

          @if (
              $partName === 'basics' ||
                  $partName === 'whatsapp-template' ||
                  $partName === 'business-hours' ||
                  $partName === 'seo' ||
                  $partName === 'advanced' ||
                  $partName === 'custom-fonts' ||
                  $partName === 'trending-video' ||
                  $partName === 'terms-conditions')
            @include('whatsapp_stores.fields')
          @elseif ($partName === 'products-categories')
            @include('whatsapp_stores.products_category.index')
          @elseif($partName === 'products')
            @include('whatsapp_stores.products.index')
          @elseif($partName === 'product-orders')
            @include('whatsapp_stores.product_orders.index')
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/image_paste_component.js') }}"></script>
@endpush
