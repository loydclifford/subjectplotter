@extends('public._partials._layout')

@section('main-content')

    <h4><i class="icon-user"></i>&nbsp;&nbsp; Forgot Password</h4>

<div class="form-box" id="login-box">
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
                <input type="text" value="{{ Input::old('email') }}" name="email" class="form-control" placeholder="{{ lang('user/attributes.placeholders.email') }}"/>
                {{ $error_msg }}
            </div>

        </div>
        <div class="footer">
            <p>
                <button type="submit" class="btn bg-olive ">Send Password &nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></button>
            </p>
            <p>
                Already have an account? <a href="{{ url('/login') }}" >click here</a>
            </p>
        </div>
    </form>
</div>

@stop