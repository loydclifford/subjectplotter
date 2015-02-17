@extends('public._partials._layout')

@section('main-content')
<div class="row-fluid">
    <div class="span5">
        <h4><i class="icon-user"></i>&nbsp;&nbsp; Login Here</h4>

        {{ Former::vertical_open('#')->method('POST')->addClass('') }}
        @include('public._partials._messages')

        <div class="form-group">
            <label class="control-label">Username</label>
            <input type="text" value="{{ Input::old('email') }}" name="email" class="form-control" placeholder="{{ lang('user/attributes.placeholders.username') }}"/>
        </div>
        <div class="form-group">
            <label class="control-label">Password</label>
            <input type="password" value="{{ Input::old('password') }}" name="password" class="form-control" placeholder="{{ lang('user/attributes.placeholders.password') }}"/>
        </div>

        <div class="form-group">
            <label>
                <input {{ is_checked(1,Input::old('remember')) }} type="checkbox" value="1" name="remember"/> Remember Me
            </label>
        </div>
        <br>

        <button type="submit" class=" btn  ">Sign In&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></button>
        <br />

        <div class="footer">
            <p><a href="{{ url('/forgot') }}">{{ lang('user/texts.forgot_password') }}</a></p>
        </div>

        {{ Former::close() }}
    </div>

    <div class="span7">
        <h4><i class="icon-question"></i>&nbsp;&nbsp;Registration</h4>
        <div class="box">
            <p>
                Only authorized student can sign in.
            </p>
        </div>
    </div>
</div>

@stop