@extends('layouts.app')
@section('title')
    {{ __('messages.virtual_backgrounds') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-around">
            <p class="text-primary">{{__('messages.common.virtual_note') }}</p>
            <div class="w-100 mb-4">
                <a href="{{ route('virtual-backgrounds.custom') }}" class="btn float-end btn-primary" data-turbo="false">{{ __('messages.common.add_custom') }} <i class="fas fa-plus"></i></a>
            </div>
            @foreach (range(1, 7) as $value)
                <div class="flip-box-h col-lg-3 mb-4">
                    <div class="flip-box-inner">
                        <div class="flip-box-front">
                            <a href="{{ route('virtual-backgrounds.create', $value) }}">
                                <img src="{{ asset('assets/img/ecards/H-Vcard/H-' . $value . '/Front.png') }}" alt=""
                                    data-id="{{ $value }}" class="downlod-ecards-{{ $value }} ecard-image w-100 h-100 object-fit-contain">
                            </a>
                        </div>
                        <div class="flip-box-back">
                            <a href="{{ route('virtual-backgrounds.create', $value) }}">
                                <img src="{{ asset('assets/img/ecards/H-Vcard/H-' . $value . '/Back.png') }}" alt=""
                                    data-id="{{ $value }}" class="downlod-ecards-{{ $value }} ecard-image w-100 h-100 object-fit-contain">
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row justify-content-around">
            @foreach (range(8, 13) as $value)
                <div class="flip-box-vertical col-lg-4 col-md-6 my-5">

                    <div class="flip-box-inner">
                        <div class="flip-box-front">
                            <a href="{{ route('virtual-backgrounds.create', $value) }}">
                                <img src="{{ asset('assets/img/ecards/V-Vcard/V-' . $value . '/Front.png') }}"
                                    alt="" data-id="{{ $value }}"
                                    class="downlod-ecards-{{ $value }} ecard-image">
                            </a>
                        </div>
                        <div class="flip-box-back">
                            <a href="{{ route('virtual-backgrounds.create', $value) }}">
                                <img src="{{ asset('assets/img/ecards/V-Vcard/V-' . $value . '/Back.png') }}"
                                    alt="" data-id="{{ $value }}"
                                    class="downlod-ecards-{{ $value }} ecard-image">
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
@endsection
