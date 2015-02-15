<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'admin_auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'subject-schedules'), function()
    {
        Route::get('/','Admin_SubjectScheduleController@getIndex');
        Route::post('/','Admin_SubjectScheduleController@postIndex');
    });

}); // ./end group (prefix=conf('admin::uri'))
