<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'subject-schedules'), function()
    {
        Route::get('/','SubjectScheduleController@getIndex');
        Route::post('/','SubjectScheduleController@postIndex');
    });

}); // ./end group (prefix=conf('admin::uri'))
