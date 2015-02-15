@extends('public._partials._layout')

@section('main-content-header')
<h1>
    500 Error Page
</h1>
@overwrite

@section('main-content')
<div class="error-page">
    <h2 class="headline">500</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> Oops! Something went wrong.</h3>
        <p>
            We will work on fixing that right away.
            Meanwhile, you may <a href="{{ admin_url('/dashboard'); }}">return to dashboard</a> or try using the search form.
        </p>
        {{--<form class="search-form">--}}
            {{--<div class="input-group">--}}
                {{--<input type="text" placeholder="Search" class="form-control" name="search">--}}
                {{--<div class="input-group-btn">--}}
                    {{--<button class="btn btn-info" name="submit" type="submit"><i class="fa fa-search"></i></button>--}}
                {{--</div>--}}
            {{--</div><!-- /.input-group -->--}}
        {{--</form>--}}
    </div>
</div>
@stop