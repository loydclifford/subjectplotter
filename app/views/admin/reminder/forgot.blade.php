@extends('admin._partials._auth_layout')

@section('main-content')

<div class="form-box" id="login-box">
    <div class="header">{{ lang('user::reminders.forgot_page_title') }}</div>
    {{ Form::open(array(
        'class' => 'parsley-form',
        'url' => '#',
        'id' => 'forgot_password_form',
        'method' => 'POST',
        // 'novalidate' => 'novalidate',
    )) }}

        <input type="hidden" name="return_url" value="{{ URL::current() }}"/>
        <div class="body bg-gray">

            @include('admin._partials._messages')

            <?php list($error_msg, $error_class) = get_error('email', $errors) ?>
            <div class="form-group {{ $error_class }}">
                <input type="text" value="{{ Input::old('email') }}" name="email" class="form-control" placeholder="{{ lang('user::attributes.placeholders.email') }}"/>

                {{ $error_msg }}
            </div>

        </div>
        <div class="footer">
            <button type="submit" class="btn bg-olive btn-block">{{ lang('user::reminders.submit_forgot') }}</button>
            <a href="{{ admin_url('/login') }}" class="btn bg-olive btn-block">{{ lang('user::reminders.back_to_sign_in') }}</a>
        </div>
    </form>
</div>

@stop