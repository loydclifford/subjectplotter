<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>{{ trans('user::global.Reset password') }}</h2>

        <div>
            {{ trans('user::global.To reset your password, complete this form:') }} {{ Html::link(URL::to('/account/reset', array($token)), 'Click here') }}.
        </div>
        <p>{{ lang('user::global.Or point your browser to this address:') }} <br /> {{  URL::to('/account/reset', array($token)) }}</p>
    </body>
</html>
