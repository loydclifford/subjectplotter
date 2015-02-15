<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'students'), function()
    {
        Route::get('/','Admin_StudentController@getIndex');

        Route::get('/create','Admin_StudentController@getCreate');
        Route::post('/create','Admin_StudentController@postCreate')->before('csrf');

        Route::get('/{student}/edit','Admin_StudentController@getEdit');
        Route::post('/{student}/edit','Admin_StudentController@postEdit')->before('csrf');

        Route::get('/{student}/view','Admin_StudentController@getView');

        Route::get('/delete','Admin_StudentController@getDelete')->before('csrf');

        Route::get('/export','Admin_StudentController@getExport')->before('csrf');
        Route::get('/search-select','Admin_StudentController@getSearchSelect')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
