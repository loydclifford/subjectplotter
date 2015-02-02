<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'subjects'), function()
    {
        Route::get('/','SubjectController@getIndex');

        Route::get('/create','SubjectController@getCreate');
        Route::post('/create','SubjectController@postCreate')->before('csrf');

        Route::get('/{subject}/edit','SubjectController@getEdit');
        Route::post('/{subject}/edit','SubjectController@postEdit')->before('csrf');

        Route::get('/{subject}/view','SubjectController@getView');

        Route::get('/delete','SubjectController@getDelete')->before('csrf');

        Route::get('/export','SubjectController@getExport')->before('csrf');
        Route::get('/search-select','SubjectController@getSearchSelect')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
