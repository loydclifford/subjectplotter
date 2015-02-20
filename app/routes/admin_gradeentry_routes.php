<?php

/*
|--------------------------------------------------------------------------
| Public Application Routes (Guests)
|--------------------------------------------------------------------------
*/



Route::group(array('prefix'=>'admin', 'before'=>'admin_auth'), function()
{
    //[url]/[prefix]
    Route::group(array('prefix'=>'grade-entry'), function()
    {
        Route::get('/', 'Admin_GradeEntryController@getIndex');
/*
        Route::get('/create', 'Admin_GradeEntryController@getCreate');
        Route::post('/create', 'Admin_GradeEntryController@postCreate')->before('csrf');

        Route::get('/{grade-entry}/edit', 'Admin_GradeEntryController@getEdit');
        Route::post('/{grade-entry}/edit', 'Admin_GradeEntryController@postEdit')->before('csrf');

        Route::get('/{grade-entry}/view', 'Admin_GradeEntryController@getView');

        Route::get('/delete', 'Admin_GradeEntryController@getDelete')->before('csrf');

        Route::get('/export', 'Admin_GradeEntryController@getExport')->before('csrf');
        Route::get('/search-select', 'Admin_GradeEntryController@getSearchSelect')->before('csrf');
*/
    });

}); // ./end group (prefix=conf('admin::uri'))
