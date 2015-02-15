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

            Route::post('/add-schedule','SubjectScheduleSetSchedulesController@postAddUpdateSchedule');
            Route::post('/update-schedule','SubjectScheduleSetSchedulesController@postAddUpdateSchedule');
            Route::get('/remove-schedule','SubjectScheduleSetSchedulesController@getRemoveSchedule');
                Route::get('/get-form-edit-schedule','SubjectScheduleSetSchedulesController@getFormEditSchedule');
        });
    });

}); // ./end group (prefix=conf('admin::uri'))
