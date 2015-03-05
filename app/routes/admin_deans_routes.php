<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'admin_auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'deans'), function()
    {
        Route::get('/','Admin_DeanController@getIndex');

        Route::get('/create','Admin_DeanController@getCreate');
        Route::post('/create','Admin_DeanController@postCreate')->before('csrf');

        Route::get('/{instructor}/edit','Admin_DeanController@getEdit');
        Route::post('/{instructor}/edit','Admin_DeanController@postEdit')->before('csrf');

        Route::get('/{instructor}/view','Admin_DeanController@getView');

        Route::get('/delete','Admin_DeanController@getDelete')->before('csrf');

        Route::get('/export','Admin_DeanController@getExport')->before('csrf');
        Route::get('/search-select','Admin_DeanController@getSearchSelect')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
