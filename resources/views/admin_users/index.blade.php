@extends('layouts.app')
@section('title')
  {{ __('messages.admins') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column table-striped">
      @include('flash::message')

      <ul class="nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap" id="adminTabs" role="tablist">
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link active p-0" href="{{ route('admins.index') }}">
            {{ __('messages.admins') }}
          </a>
        </li>
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link p-0" href="{{ route('receipts.all') }}">
            {{ __('messages.receipts.receipts') }}
          </a>
        </li>
      </ul>

      <livewire:super-admin-table lazy />
    </div>
  </div>
  @include('users.changePassword')
@endsection
