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
        Route::group(array('prefix'=>'categories'), function()
        {
            Route::get('/', 'SubjectCategoryController@getIndex');

            Route::get('/create', 'SubjectCategoryController@getCreate');
            Route::post('/create', 'SubjectCategoryController@postCreate')->before('csrf');

            Route::get('/{subjectcategory}/edit', 'SubjectCategoryController@getEdit');
            Route::post('/{subjectcategory}/edit', 'SubjectCategoryController@postEdit')->before('csrf');

            Route::get('/{subjectcategory}/view', 'SubjectCategoryController@getView');

            Route::get('/delete', 'SubjectCategoryController@getDelete')->before('csrf');

            Route::get('/export', 'SubjectCategoryController@getExport')->before('csrf');
            Route::get('/search-select', 'SubjectCategoryController@getSearchSelect')->before('csrf');
        });
    });

}); // ./end group (prefix=conf('admin::uri'))
