<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'instructors'), function()
    {
        Route::get('/','InstructorController@getIndex');

        Route::get('/create','InstructorController@getCreate');
        Route::post('/create','InstructorController@postCreate')->before('csrf');

        Route::get('/{instructor}/edit','InstructorController@getEdit');
        Route::post('/{instructor}/edit','InstructorController@postEdit')->before('csrf');

        Route::get('/{instructor}/view','InstructorController@getView');

        Route::get('/delete','InstructorController@getDelete')->before('csrf');

        Route::get('/export','InstructorController@getExport')->before('csrf');
        Route::get('/search-select','InstructorController@getSearchSelect')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
