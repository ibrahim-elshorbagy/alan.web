@extends('layouts.app')
@section('title')
  {{ __('messages.acknowledgment_list') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <livewire:acknowledgments-table />
    </div>
  </div>
@endsection
