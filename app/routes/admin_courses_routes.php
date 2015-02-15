<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'admin_auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'courses'), function()
    {
        Route::get('/','Admin_CourseController@getIndex');

        Route::get('/create','Admin_CourseController@getCreate');
        Route::post('/create','Admin_CourseController@postCreate')->before('csrf');

        Route::get('/{course}/edit','Admin_CourseController@getEdit');
        Route::post('/{course}/edit','Admin_CourseController@postEdit')->before('csrf');

        Route::get('/{course}/view','Admin_CourseController@getView');

        Route::get('/delete','Admin_CourseController@getDelete')->before('csrf');

        Route::get('/export','Admin_CourseController@getExport')->before('csrf');
        Route::get('/search-select','Admin_CourseController@getSearchSelect')->before('csrf');
        Route::get('/get-course-years-options','Admin_CourseController@getCourseYearsOptions');
    });

}); // ./end group (prefix=conf('admin::uri'))
