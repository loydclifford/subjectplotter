<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'auth'), function()
{
    // [url]/admin
    Route::group(array('prefix'=>'rooms'), function()
    {
        Route::get('/','RoomController@getIndex');

        Route::get('/create','RoomController@getCreate');
        Route::post('/create','RoomController@postCreate')->before('csrf');

        Route::get('/{room}/edit','RoomController@getEdit');
        Route::post('/{room}/edit','RoomController@postEdit')->before('csrf');

        Route::get('/{room}/view','RoomController@getView');

        Route::get('/delete','RoomController@getDelete')->before('csrf');

        Route::get('/export','RoomController@getExport')->before('csrf');
        Route::get('/search-select','RoomController@getSearchSelect')->before('csrf');
    });

}); // ./end group (prefix=conf('admin::uri'))
