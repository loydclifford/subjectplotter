<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'admin_auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'instructors'), function()
    {
        Route::get('/','Admin_InstructorController@getIndex');

        Route::get('/create','Admin_InstructorController@getCreate');
        Route::post('/create','Admin_InstructorController@postCreate')->before('csrf');

        Route::get('/{instructor}/edit','Admin_InstructorController@getEdit');
        Route::post('/{instructor}/edit','Admin_InstructorController@postEdit')->before('csrf');

        Route::get('/{instructor}/view','Admin_InstructorController@getView');

        Route::get('/delete','Admin_InstructorController@getDelete')->before('csrf');

        Route::get('/export','Admin_InstructorController@getExport')->before('csrf');
        Route::get('/search-select','Admin_InstructorController@getSearchSelect')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
