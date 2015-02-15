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
        Route::get('/','StudentController@getIndex');

        Route::get('/create','StudentController@getCreate');
        Route::post('/create','StudentController@postCreate')->before('csrf');

        Route::get('/{student}/edit','StudentController@getEdit');
        Route::post('/{student}/edit','StudentController@postEdit')->before('csrf');

        Route::get('/{student}/view','StudentController@getView');

        Route::get('/delete','StudentController@getDelete')->before('csrf');

        Route::get('/export','StudentController@getExport')->before('csrf');
        Route::get('/search-select','StudentController@getSearchSelect')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
