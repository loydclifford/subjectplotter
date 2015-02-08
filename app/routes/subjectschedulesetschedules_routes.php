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
        Route::group(array('prefix'=>'set-schedules'), function()
        {
            Route::get('/','SubjectScheduleSetSchedulesController@getIndex');
            Route::post('/add-subject','SubjectScheduleSetSchedulesController@postAddSubject');
            Route::get('/remove-subject','SubjectScheduleSetSchedulesController@getRemoveSubject');

            Route::post('/add-schedule','SubjectScheduleSetSchedulesController@postAddSchedule');
            Route::get('/remove-schedule','SubjectScheduleSetSchedulesController@getRemoveSchedule');
        });
    });

}); // ./end group (prefix=conf('admin::uri'))
