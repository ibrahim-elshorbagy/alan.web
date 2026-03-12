@extends('layouts.app')
@section('title')
  {{ __('messages.shop_visits.edit_visit') }} - {{ $salesUser->first_name }} {{ $salesUser->last_name }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h1>{{ __('messages.shop_visits.edit_visit') }}</h1>
          <a class="btn btn-outline-primary float-end"
            href="{{ route('admin.sales-visits.index', $salesUser->id) }}">{{ __('messages.common.back') }}</a>
        </div>
        <div class="col-12">
          @include('layouts.errors')
        </div>
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.sales-visits.update', $visit->id) }}" method="POST" id="shopVisitAdminEditForm">
              @csrf
              @method('PUT')
              @include('sales.shop_visits.admin_fields')
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection