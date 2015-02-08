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
        Route::get('/','SettingController@getIndex');
        Route::get('/semester','SettingController@getSemester');

        Route::post('/update','SettingController@postUpdate')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
