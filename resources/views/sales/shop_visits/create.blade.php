@extends('layouts.app')
@section('title')
  {{ __('messages.shop_visits.add_visit') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h1>{{ __('messages.shop_visits.add_visit') }}</h1>
          <a class="btn btn-outline-primary float-end"
            href="{{ route('sales.shop-visits.index') }}">{{ __('messages.common.back') }}</a>
        </div>
        <div class="col-12">
          @include('layouts.errors')
        </div>
        <div class="card">
          <div class="card-body">
            <form action="{{ route('sales.shop-visits.store') }}" method="POST" id="shopVisitCreateForm">
              @csrf
              @include('sales.shop_visits.fields', ['visit' => null])
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection