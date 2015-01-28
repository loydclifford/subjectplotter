<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>{{ lang('user/global.Welcome') }} {{{ $user->present()->getDisplayName() }}}</h2>

        <p><b>{{ lang('user/global.Account:') }}</b> {{{ $user->email }}}</p>
        <p>{{ lang('user/global.To activate your account') }}, <a href="{{  URL::to('/account/activate', array($user->id, urlencode($user->confirmation_code))) }}">{{ trans('user::global.click here') }}.</a></p>
        <p>{{ lang('user/global.Or point your browser to this address:') }} <br /> {{  URL::to('/account/activate', array($user->id, urlencode($user->confirmation_code))) }}</p>
        <p>{{ lang('user/global.Thank you') }}</p>
    </body>
</html>
