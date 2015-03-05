@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ lang('dean/texts.page_title') }}
    <a  class="btn btn-primary" href="{{ admin_url('/deans/create') }}"><i class="fa fa-plus"></i> {{ lang('dean/texts.create') }}</a>
</h1>
@overwrite

@section('main-content')

    @include('admin._partials._messages')

    @include('admin.dean._tblist')
@stop

