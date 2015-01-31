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
        Route::get('/create','CourseYearController@getCreate');
        Route::post('/create','CourseYearController@postCreate')->before('csrf');

        Route::get('/{course_year}/edit','CourseYearController@getEdit');
        Route::post('/{course_year}/edit','CourseYearController@postEdit')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
