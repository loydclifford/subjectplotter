<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'settings'), function()
    {
        Route::get('/','Admin_SettingController@getIndex');
        Route::get('/semester','Admin_SettingController@getSemester');

        Route::post('/update','Admin_SettingController@postUpdate')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
