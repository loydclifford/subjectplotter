<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'courses'), function()
    {
        Route::get('/','CourseController@getIndex');

        Route::get('/create','CourseController@getCreate');
        Route::post('/create','CourseController@postCreate')->before('csrf');

        Route::get('/{course}/edit','CourseController@getEdit');
        Route::post('/{course}/edit','CourseController@postEdit')->before('csrf');

        Route::get('/{course}/view','CourseController@getView');

        Route::get('/delete','CourseController@getDelete')->before('csrf');

        Route::get('/export','CourseController@getExport')->before('csrf');
        Route::get('/search-select','CourseController@getSearchSelect')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
