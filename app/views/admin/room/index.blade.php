@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ lang('room/texts.page_title') }}
    <a  class="btn btn-primary" href="{{ admin_url('/rooms/create') }}"><i class="fa fa-plus"></i> {{ lang('room/texts.create') }}</a>
</h1>
@overwrite

@section('main-content')

    @include('admin._partials._messages')

    @include('admin.room._tblist')
@stop

