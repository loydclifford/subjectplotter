@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ lang('instructor/texts.page_title') }}
    <a  class="btn btn-primary" href="{{ admin_url('/instructors/create') }}"><i class="fa fa-plus"></i> {{ lang('instructor/texts.create') }}</a>
</h1>
@overwrite

@section('main-content')

    @include('admin._partials._messages')

    @include('admin.instructor._tblist')
@stop

