<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

Route::filter('admin_guest', function()
{
	if (user_check() && user_get()->user_type == User::USER_TYPE_ADMIN)
	{
		return Redirect::intended(admin_url('/dashboard'));
	}
});

Route::filter('admin_auth', function()
{
	if ( ! user_check() || user_get()->user_type != User::USER_TYPE_ADMIN)
	{
		if (Request::ajax())
		{
			return Response::json(array(
				'status' => RESULT_NOT_LOG_IN
			), 401);
		}

		return Redirect::guest('/admin/login');
	}
});

Route::filter('student_guest', function()
{
	if (user_check() && user_get()->user_type == User::USER_TYPE_STUDENT)
	{
		return Redirect::intended(url('/dashboard'));
	}
});

Route::filter('student_auth', function()
{
	if ( ! user_check() || user_get()->user_type != User::USER_TYPE_STUDENT)
	{
		if (Request::ajax())
		{
			return Response::json(array(
				'status' => RESULT_NOT_LOG_IN
			), 401);
		}

		return Redirect::guest('/login');
	}
});


App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		return Redirect::guest('login');
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| Handle HTTP Global Errors and Exceptions
|--------------------------------------------------------------------------
|
| If ajax request then return status code and resposne with json
| else, display page if ENV is production
|
*/

App::error(function($exception,$status)
{
	if (App::environment() == ENV_PRODUCTION || ! conf('app.debug'))
	{
		switch($status)
		{
			case 404:
				// Get data information
				$controller = new BaseController();
				$controller->data['enable_breadcrumb'] = false; // disable breadcrumb
				$controller->data['meta']->title = "404 Not Found";

				// Admin not found
				if (Request::segment(1) == 'admin')
				{
					return Response::view('admin.404', $controller->data, 404);
				}

				return Response::view('public.404', $controller->data, 404);
				break;

			default :
				// Admin error
				// Get data information
				$controller = new BaseController();
				$controller->data['enable_breadcrumb'] = false; // disable breadcrumb
				$controller->data['meta']->title = "500 Internal Server Error";

				if (Request::segment(1) == 'admin')
				{
					return Response::view('admin.500', $controller->data, 500);
				}

				// public error
				return Response::view('public.500', $controller->data, 500);

				break;
		}
	}
});


/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{

	if (Session::token() !== Input::get('_token'))
	{
		if (Request::ajax())
		{
			return Response::json(array(
				'status' => RESULT_INVALID_TOKEN
			), 401);
		}
		else
		{
			throw new Illuminate\Session\TokenMismatchException;
		}
	}
});

