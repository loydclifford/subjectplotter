@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ lang('course/texts.page_title') }}
    <a  class="btn btn-primary" href="{{ admin_url('/courses/create') }}"><i class="fa fa-plus"></i> {{ lang('course/texts.create') }}</a>
</h1>
@overwrite

@section('main-content')

    @include('admin._partials._messages')

    @include('admin.course._tblist')
@stop

