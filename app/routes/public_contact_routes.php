<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/

Route::get('/contact','Public_ContactController@getIndex');
Route::post('/contact','Public_ContactController@postIndex');
