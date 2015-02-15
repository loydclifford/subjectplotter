<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/

Route::group(array('before'=>'auth'),function() {

    Route::group(array('prefix'=>"admin"), function()
    {
        Route::get('/dashboard','Admin_AdminController@getIndex');
    });

});
