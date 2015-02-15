
@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ lang('student/texts.page_title') }}
    <a  class="btn btn-primary" href="{{ admin_url('/students/create') }}"><i class="fa fa-plus"></i> {{ lang('student/texts.create') }}</a>
</h1>
@overwrite

@section('main-content')

    @include('admin._partials._messages')

    @include('admin.student._tblist')
@stop
