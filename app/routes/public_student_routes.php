<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/


Route::group(array('before'=>'student_auth'), function() {
    Route::get('/dashboard', 'Public_StudentController@getIndex');
    Route::get('/accounts', 'Public_StudentController@getAccount');
    Route::post('/accounts', 'Public_StudentController@postAccount')->before('csrf');
});