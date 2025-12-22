@extends('layouts.app')
@section('title')
    {{__('messages.blogs')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column table-striped">
            @include('flash::message')
            <livewire:blog-table/>
        </div>
    </div>
@endsection
