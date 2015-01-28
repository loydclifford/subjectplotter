@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    Attempting to logout
</h1>
@overwrite

@section('main-content')
<div class="error-page no-headline">
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> You are attempting to log out of {{ get_option('site_title','__') }}.</h3>
        <p>
            Do you really want to <a href="{{ admin_logout_url(); }}">Logout</a>.
        </p>
    </div>
</div>
@stop