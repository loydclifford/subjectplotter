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