<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/

Route::group(array('prefix'=>'admin', 'before'=>'admin_auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'course-years'), function()
    {
        Route::post('/create','Admin_CourseYearController@postCreate')->before('csrf');
        Route::post('/update','Admin_CourseYearController@postUpdate')->before('csrf');
        Route::post('/reorder','Admin_CourseYearController@postReorder')->before('csrf');

        Route::get('/delete','Admin_CourseYearController@getDelete');
    });

}); // ./end group (prefix=conf('admin::uri'))
