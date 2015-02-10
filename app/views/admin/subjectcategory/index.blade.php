@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ lang('subjectcategory/texts.page_title') }}
    <a  class="btn btn-primary" href="{{ admin_url('/subjects/create') }}"><i class="fa fa-plus"></i> {{ lang('subject/texts.create') }}</a>
</h1>
@overwrite

@section('main-content')

    @include('admin._partials._messages')

    @include('admin.subjectcategory._tblist')
@stop
