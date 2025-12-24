@extends('layouts.app')
@section('title')
    {{__('messages.vcard.advanced')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            @include('layouts.errors')
            <div class="card">
                <div class="card-body d-md-flex">
                    @include('settings.front_cms.front_cms_menu')
                    <div class="container-fluid">
                    {!! Form::open(['route' => 'setting.advanced.update','enctype' => 'multipart/form-data']) !!}
                        @include('settings.advanced.fields')
                    {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
