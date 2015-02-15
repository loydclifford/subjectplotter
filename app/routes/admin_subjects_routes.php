<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'admin_auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'subjects'), function()
    {
        Route::get('/','Admin_SubjectController@getIndex');

        Route::get('/create','Admin_SubjectController@getCreate');
        Route::post('/create','Admin_SubjectController@postCreate')->before('csrf');

        Route::get('/{subject}/edit','Admin_SubjectController@getEdit');
        Route::post('/{subject}/edit','Admin_SubjectController@postEdit')->before('csrf');

        Route::get('/{subject}/view','Admin_SubjectController@getView');

        Route::get('/delete','Admin_SubjectController@getDelete')->before('csrf');

        Route::get('/export','Admin_SubjectController@getExport')->before('csrf');
        Route::get('/search-select','Admin_SubjectController@getSearchSelect')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
