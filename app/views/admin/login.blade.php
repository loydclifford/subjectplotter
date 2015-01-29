@extends('admin._partials._auth_layout')

@section('main-content')

<div class="form-box" id="login-box">
    <div class="header">{{ lang('user/texts.sign_in') }}</div>
    {{ Former::vertical_open('#')->method('POST')->addClass('') }}

        <input type="hidden" name="return_url" value="{{ URL::current() }}"/>
        <div class="body bg-gray">

            @include('admin._partials._messages')

            <div class="form-group">
                <input type="text" value="{{ Input::old('email') }}" name="email" class="form-control" placeholder="{{ lang('user/attributes.placeholders.username') }}"/>
            </div>
            <div class="form-group">
                <input type="password" value="{{ Input::old('password') }}" name="password" class="form-control" placeholder="{{ lang('user/attributes.placeholders.password') }}"/>
            </div>

            @if(conf('user::enable_remember_me'))
            <div class="form-group">
                <label>
                    <input {{ is_checked(1,Input::old('remember')) }} type="checkbox" value="1" name="remember"/> {{ lang('user/attributes.labels.remember_me') }}
                </label>
            </div>
            @endif
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-olive btn-block">{{ lang('user/texts.sign_in') }}</button>
            <p><a href="{{ admin_url('/password/forgot') }}">{{ lang('user/texts.forgot_password') }}</a></p>
        </div>

    {{ Former::close() }}
</div>

@stop