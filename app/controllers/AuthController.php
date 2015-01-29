<?php

class AuthController extends BaseController {

    public function getLogin()
    {
        $this->data['meta']->title = "Admin Login";

        return View::make('admin.login')->with($this->data);
    }

    public function postLogin()
    {
        $simple_auth = new SimpleAuth(array(
            'email'          => Input::get('email'),
            'password'          => Input::get('password'),
            'remember'          => Input::get('remember', 0),
            'confirmed_only'    => 0,
            'throttle_limit'       => 20,
            'throttle_time_period' => 20,
            'signup_cache'         => (20 * 4),
        ), new User);

        if ($simple_auth->success())
        {
            Event::fire('user.login');

            if (User::USER_ROOT)
            return Redirect::intended(admin_url('/dashboard'));
        }
        else
        {
            if (Request::ajax())
            {
                return Response::json(array(
                    'status' => 'error',
                    'errorMsg' => $simple_auth->getError(),
                ));
            }
            else
            {
                Session::flash(ERROR_MESSAGE, $simple_auth->getError());

                return Redirect::to(Input::get('return_url'))
                    ->withInput();
            }
        }
    }

    public function getLogout()
    {
        if (Input::get('_token') != Session::get('_token'))
        {
            $this->data['title'] = "Failure notifice";

            return View::make('admin.attempt_logout',$this->data);
        }

        Session::flash('message_success','Successfully logged out.');

        // Logout
        Auth::logout();

        return Redirect::to( admin_url("/login") );
    }

}