@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ lang('gradeentry/texts.page_title') }}
</h1>
@overwrite

@section('main-content')

    @include('admin._partials._messages')

    @include('admin.grade-entry._tblist')
@stop
