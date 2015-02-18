<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/

        Route::get('/login','Public_AuthController@getLogin');
        Route::post('/login','Public_AuthController@postLogin');
        Route::get('/logout','Public_AuthController@getLogout');

        // Forgot Password
        Route::get('/forgot','Public_RemindersController@getRemind');
        Route::post('/forgot','Public_RemindersController@postRemind');

        // Reset Password
        Route::get('/reset/{token}','Public_RemindersController@getReset');
        Route::post('/reset','Public_RemindersController@postReset');

