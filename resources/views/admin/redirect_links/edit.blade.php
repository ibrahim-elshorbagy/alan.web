@extends('layouts.app')
@section('title')
  {{ __('messages.redirect_links.edit') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h1>{{ __('messages.redirect_links.edit') }}</h1>
          <a class="btn btn-outline-primary float-end"
            href="{{ route('redirect-links.index') }}">{{ __('messages.common.back') }}</a>
        </div>
        <div class="col-12">
          @include('layouts.errors')
        </div>
        <div class="card">
          <div class="card-body">
            {!! Form::open([
                'route' => ['redirect-links.update', $redirectLink->id],
                'method' => 'put',
                'files' => true,
                'id' => 'redirectLinkEditForm',
            ]) !!}
            @include('admin.redirect_links.fields')
            {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
