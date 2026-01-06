@extends('layouts.app')
@section('title')
  {{ __('messages.redirect_links.title') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column table-striped">
      @include('flash::message')
      <livewire:redirect-links-table lazy />
    </div>
  </div>
@endsection
