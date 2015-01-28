<?php

class RemindersController extends BaseController {

	public function getRemind()
	{
		return View::make('admin.reminder.forgot');
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()
	{
		switch ($response = Password::user()->remind(Input::except(array('_return_url', '_success_url'))))
		{
			case Password::INVALID_USER:
				return Redirect::back()->with(ERROR_MESSAGE, Lang::get('user::reminders.'.$response))
					->withInput();

			case Password::REMINDER_SENT:
				Event::fire('user.forgot', Input::get('email'));
				return Redirect::back()->with(SUCCESS_MESSAGE, lang('user::reminders.password_forgot'));
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);

		$this->data['token'] = $token;
		return View::make('public.default.auth.reset')->with($this->data);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
		$credentials = array(
			'email' => Input::get('reset.email'),
			'password' => Input::get('reset.new_password'),
			'password_confirmation' => Input::get('reset.new_password_confirmation'),
			'token' => Input::get('reset.token')
		);

		$response = Password::user()->reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			$user->save();
		});

		$error_redirect = Redirect::back()
					->withInput();

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return $error_redirect->with(ERROR_MESSAGE, Lang::get($response));

			case Password::PASSWORD_RESET:
				Event::fire('user.reset', Input::get('popup_forgot.email'));
				return Redirect::to('/')
					->with('POPUP_LOGIN_'.SUCCESS_MESSAGE, lang('user::global.password_reset'))
					->with(DO_SHOW_POPUP, Input::get('_popup_modal'));
				break;
		}
	}

}
