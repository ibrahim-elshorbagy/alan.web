@extends('layouts.app')
@section('title')
    {{__('messages.about_us.about_us')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('layouts.errors')
            @include('flash::message')
            <div class="card">
                <div class="card-body d-md-flex">
                    @include('settings.front_cms.front_cms_menu')
                    {!! Form::open(['route' => 'front-slider.store','enctype' => 'multipart/form-data']) !!}
                    <div class="row">
                        @foreach($frontSlider as $about)
                            <div class="col-md-4 col-12">
                                @include('sadmin.frontSlider.frontSlider')
                            </div>
                        @endforeach
                    </div>
                    <div>
                        {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-3']) }}
                        <a href="" type="reset" class="btn btn-secondary">{{__('messages.common.discard')}}</a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">

    </div>
@endsection
