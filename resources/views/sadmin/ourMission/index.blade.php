@extends('layouts.app')
@section('title')
    {{ __('messages.theme3.our_mission') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('layouts.errors')
            @include('flash::message')
            <div class="card">
                <div class="card-body d-md-flex">
                    @include('settings.front_cms.front_cms_menu')
                    <form action="{{ route('our-mission.update') }}" method="post">
                        @csrf
                        <div class="col-lg-12">
                            <div class="row">
                                <input type="hidden" name="part" value="">
                                <div class="col-12 mt-5">
                                    {{ Form::label('Title', __('messages.front_cms.title') . ':', ['class' => 'form-label required']) }}
                                    {{ Form::text('our_mission_title', isset($setting['our_mission_title']) ? $setting['our_mission_title'] : null, ['class' => 'form-control form-control-color w-100 mb-3', 'placeholder' => __('messages.front_cms.title'), 'id' => 'our_mission_title']) }}
                                </div>
                                <div class="col-sm-6 mt-5">
                                    {{ Form::label('Description', __('messages.front_cms.description') . ' 1:', ['class' => 'form-label required']) }}
                                    {{ Form::textarea('our_mission_description1', isset($setting['our_mission_description1']) ? $setting['our_mission_description1'] : null, ['class' => 'form-control form-control-color w-100', 'placeholder' => __('messages.form.short_description'), 'id' => 'our_mission_description1', 'rows' => 4]) }}
                                </div>
                                <div class="col-sm-6 mt-5">
                                    {{ Form::label('Description', __('messages.front_cms.description') . ' 2:', ['class' => 'form-label required']) }}
                                    {{ Form::textarea('our_mission_description2', isset($setting['our_mission_description2']) ? $setting['our_mission_description2'] : null, ['class' => 'form-control form-control-color w-100', 'placeholder' => __('messages.form.short_description'), 'id' => 'our_mission_description2', 'rows' => 4]) }}
                                </div>
                            </div>
                            <div class="col-lg-12 mt-5">
                                <div class="col-lg-12 d-flex">
                                    <button type="submit" class="btn btn-primary me-3" id="bannerdataSave">
                                        {{ __('messages.common.save') }}
                                    </button>
                                    <a href="{{ route('our-mission.index') }}"
                                        class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
