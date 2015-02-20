<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'admin_auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'schedule-requests'), function()
    {
        Route::get('/','Admin_SubjectRequestController@getIndex');

        Route::get('/{student_plotting}/view','Admin_SubjectRequestController@getView');
        Route::get('/{student_plotting}/deny','Admin_SubjectRequestController@getDeny');
        Route::get('/{student_plotting}/approved','Admin_SubjectRequestController@getApprove');
    });

}); // ./end group (prefix=conf('admin::uri'))
