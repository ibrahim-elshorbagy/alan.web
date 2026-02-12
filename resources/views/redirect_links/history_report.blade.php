@extends('layouts.app')
@section('title')
  {{ __('messages.redirect_links.history_report') }}
@endsection
@section('content')
  <div class="container-fluid">
    <livewire:redirect-links-history-report />
  </div>
@endsection
