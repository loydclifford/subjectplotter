<?php

class Public_AuthController extends BaseController {

    public function getLogin()
    {
        $this->data['meta']->title = "Student Login";
        $this->data['active_menu'] = 'login';

        return View::make('public.login')->with($this->data);
    }

    public function postLogin()
    {
        $found_user = User::where('email', Input::get('email'))->whereIn('user_type', array(
            User::USER_TYPE_INSTRUCTOR, User::USER_TYPE_STUDENT
        ))->first();

        if (!$found_user)
        {
            return Redirect::to('/login')->with(ERROR_MESSAGE, 'Invalid Login');
        }

        $simple_auth = new SimpleAuth(array(
            'email'                 => Input::get('email'),
            'password'              => Input::get('password'),
            'remember'              => Input::get('remember', 0),
            'confirmed_only'        => 0,
            'throttle_limit'        => 20,
            'throttle_time_period'  => 20,
            'signup_cache'          => (20 * 4),
        ), new User);

        if ($simple_auth->success())
        {
            Event::fire('user.login');

            return Redirect::intended('/dashboard');
        }
        else
        {
            Session::flash(ERROR_MESSAGE, $simple_auth->getError());

            return Redirect::to('/login')
                ->withInput();
        }
    }

    public function getLogout()
    {
        Session::flash('message_success','Successfully logged out.');

        // Logout
        Auth::logout();

        return Redirect::to('/login');
    }

    public function getReset()
    {
        {
            if ($this->isPostRequest()) {
                $response = $this->getPasswordRemindResponse();

                if ($this->isInvalidUser($response)) {
                    return Redirect::back()
                        ->withInput()
                        ->with("error", Lang::get($response));
                }

                return Redirect::back()
                    ->with("status", Lang::get($response));
            }

            return View::make("user/request");
        }
    }

    public function postReset()
    {
        $credentials = array('email' => Input::get('email'));
        return Password::remind($credentials);
    }
}
