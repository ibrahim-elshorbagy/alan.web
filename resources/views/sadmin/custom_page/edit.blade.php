@extends('layouts.app')
@section('title')
    {{__('messages.custom_page.edit_custom_page')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-end mb-5">
                    <h1>{{__('messages.custom_page.edit_custom_page')}}</h1>
                    <a class="btn btn-outline-primary float-end"
                       href="{{ route('custom.page.index') }}">{{ __('messages.common.back') }}</a>
                </div>

                <div class="col-12">
                    @include('layouts.errors')
                </div>
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['route' => ['custom.page.update', $customPage->id], 'method' => 'post', 'id' => 'customPageEditForm']) !!}
                        @include('sadmin.custom_page.fields')
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
