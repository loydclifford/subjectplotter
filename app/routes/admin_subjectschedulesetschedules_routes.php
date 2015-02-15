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
        Route::group(array('prefix'=>'set-schedules'), function()
        {
            Route::get('/','Admin_SubjectScheduleSetSchedulesController@getIndex');
            Route::post('/add-subject','Admin_SubjectScheduleSetSchedulesController@postAddSubject');
            Route::get('/remove-subject','Admin_SubjectScheduleSetSchedulesController@getRemoveSubject');

            Route::post('/add-schedule','Admin_SubjectScheduleSetSchedulesController@postAddUpdateSchedule');
            Route::post('/update-schedule','Admin_SubjectScheduleSetSchedulesController@postAddUpdateSchedule');
            Route::get('/remove-schedule','Admin_SubjectScheduleSetSchedulesController@getRemoveSchedule');
                Route::get('/get-form-edit-schedule','Admin_SubjectScheduleSetSchedulesController@getFormEditSchedule');
        });
    });

}); // ./end group (prefix=conf('admin::uri'))
