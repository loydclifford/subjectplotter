@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ lang('user/texts.page_title') }}
    <a  class="btn btn-primary" href="{{ admin_url('/users/create') }}"><i class="fa fa-plus"></i> {{ lang('user/texts.create') }}</a>
</h1>
@overwrite

@section('main-content')

    @include('admin._partials._messages')

    @include('admin.user._tblist')
@stop

