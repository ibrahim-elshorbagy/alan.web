@extends('layouts.app')
@section('title')
  {{ __('messages.acknowledgment_list') }}

@endsection
@section('content')
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      @include('flash::message')

      <ul class="nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap" role="tablist">
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link p-0" href="{{ route('admins.index') }}">
            {{ __('messages.admins') }}
          </a>
        </li>
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link  p-0" href="{{ route('receipts.all') }}">
            {{ __('messages.receipts.receipts') }}
          </a>
        </li>
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link active p-0" href="{{ route('acknowledgments.index') }}">
            {{ __('messages.acknowledgments') }}
          </a>
        </li>
      </ul>
      <livewire:acknowledgments-table />
    </div>
  </div>
@endsection
