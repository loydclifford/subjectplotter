<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/

Route::group(array('before'=>'guest'),function() {

    Route::group(array('prefix'=>"admin"), function()
    {
        Route::get('/login','AuthController@getLogin');
        Route::post('/login','AuthController@postLogin');

        // Forgot Password
        Route::get('/forgot','RemindersController@getRemind');
        Route::post('/forgot','RemindersController@postRemind');

        // Reset Password
        Route::get('/reset/{token}','RemindersController@getReset');
        Route::post('/reset','RemindersController@postReset');
    });

});

Route::group(array('prefix'=>'admin', 'before'=>'auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'users'), function()
    {
        Route::get('/','UserController@getIndex');

        Route::get('/create','UserController@getCreate');
        Route::post('/create','UserController@postCreate')->before('csrf');

        Route::get('/{user}/edit','UserController@getEdit');
        Route::post('/{user}/edit','UserController@postEdit')->before('csrf');

        Route::get('/{user}/view','UserController@getView');

        Route::get('/delete','UserController@getDelete')->before('csrf');

        Route::get('/export','UserController@getExport')->before('csrf');
        Route::get('/search-select','UserController@getSearchSelect')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
