@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    404 Error Page
</h1>
@overwrite

@section('main-content')
<div class="error-page">
    <h2 class="headline text-info"> 404</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
        <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="{{ admin_url('/dashboard') }}">return to dashboard</a> or try using the search form.
        </p>
        {{--<form class="search-form">--}}
            {{--<div class="input-group">--}}
                {{--<input type="text" placeholder="Search" class="form-control" name="search">--}}
                {{--<div class="input-group-btn">--}}
                    {{--<button class="btn btn-primary" name="submit" type="submit"><i class="fa fa-search"></i></button>--}}
                {{--</div>--}}
            {{--</div><!-- /.input-group -->--}}
        {{--</form>--}}
    </div><!-- /.error-content -->
</div>
@stop