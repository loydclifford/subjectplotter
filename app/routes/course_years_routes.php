<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/

Route::group(array('prefix'=>'admin', 'before'=>'auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'course-years'), function()
    {
        Route::post('/create','CourseYearController@postCreate')->before('csrf');
        Route::post('/update','CourseYearController@postUpdate')->before('csrf');
        Route::post('/reorder','CourseYearController@postReorder')->before('csrf');

        Route::get('/delete','CourseYearController@getDelete');
    });

}); // ./end group (prefix=conf('admin::uri'))
