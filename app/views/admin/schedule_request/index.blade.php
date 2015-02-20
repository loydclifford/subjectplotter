
@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    Schedule Request
</h1>
@overwrite

@section('main-content')

    @include('admin._partials._messages')

    @include('admin.schedule_request._tblist')
@stop
