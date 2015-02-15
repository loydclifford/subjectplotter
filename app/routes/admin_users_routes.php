<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/

Route::group(array('before'=>'admin_guest'), function()
{
    Route::get('/admin/login','Admin_AuthController@getLogin');
    Route::post('/admin/login','Admin_AuthController@postLogin');

    // Forgot Password
    Route::get('/admin/forgot','Admin_RemindersController@getRemind');
    Route::post('admin/forgot','Admin_RemindersController@postRemind');

    // Reset Password
    Route::get('/admin/reset/{token}','Admin_RemindersController@getReset');
    Route::post('/admin/reset','Admin_RemindersController@postReset');
});

Route::get('/admin/logout','Admin_AuthController@getLogout');

Route::group(array('prefix'=>'admin', 'before'=>'admin_auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'users'), function()
    {
        Route::get('/test','Admin_UserController@getTest');
        Route::get('/','Admin_UserController@getIndex');

        Route::get('/create','Admin_UserController@getCreate');
        Route::post('/create','Admin_UserController@postCreate')->before('csrf');

        Route::get('/{user}/edit','Admin_UserController@getEdit');
        Route::post('/{user}/edit','Admin_UserController@postEdit')->before('csrf');

        Route::get('/{user}/view','Admin_UserController@getView');

        Route::get('/delete','Admin_UserController@getDelete')->before('csrf');

        Route::get('/export','Admin_UserController@getExport')->before('csrf');
        Route::get('/search-select','Admin_UserController@getSearchSelect')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
