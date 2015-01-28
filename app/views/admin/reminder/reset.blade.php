@extends('admin._partials._auth_layout')

@section('main-content')

<div class="form-box" id="login-box">
    <div class="header">{{ lang('user::reminders.reset_page_title') }}</div>
    {{ Former::vertical_open('#')->method('POST')->addClass('') }}
        <input type="hidden" name="_return_url" value="{{ URL::current() }}"/>
        <div class="body bg-gray">
            @include('admin._partials._messages')
                {{ Former::text('email', lang('user::reminders.labels.password'))->placeholder(lang('user::reminders.placeholder.password')) }}
                {{ Former::password('new_password', lang('user::reminders.labels.password'))->placeholder(lang('user::reminders.placeholder.password')) }}
                {{ Former::password('new_password_confirmation', lang('user::reminders.labels.password_confirmation'))->placeholder(lang('user::reminders.placeholder.password_confirmation')) }}
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-olive btn-block">{{ lang('user::reminders.btn_reset_password') }}</button>
            <a href="{{ admin_url('/login') }}" class="btn bg-olive btn-block">{{ lang('user::reminders.back_to_sign_in') }}</a>
        </div>

    <input type="hidden" name="token" value="{{ $token }}">
    {{ Former::close() }}
</div>

@stop