@extends('layouts.app')
@section('title')
  {{ __('messages.sales_customers.title') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column table-striped">
      <div class="d-flex justify-content-between align-items-end mb-5">
        <h1>{{ __('messages.sales_customers.title') }}</h1>
      </div>

      @include('flash::message')

      <livewire:sales-customers-table lazy />
    </div>
  </div>
@endsection