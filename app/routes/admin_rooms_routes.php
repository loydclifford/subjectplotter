<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'admin_auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'rooms'), function()
    {
        Route::get('/','Admin_RoomController@getIndex');

        Route::get('/create','Admin_RoomController@getCreate');
        Route::post('/create','Admin_RoomController@postCreate')->before('csrf');

        Route::get('/{room}/edit','Admin_RoomController@getEdit');
        Route::post('/{room}/edit','Admin_RoomController@postEdit')->before('csrf');

        Route::get('/{room}/view','Admin_RoomController@getView');

        Route::get('/delete','Admin_RoomController@getDelete')->before('csrf');

        Route::get('/export','Admin_RoomController@getExport')->before('csrf');
        Route::get('/search-select','Admin_RoomController@getSearchSelect')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
