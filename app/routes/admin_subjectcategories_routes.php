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
        Route::group(array('prefix'=>'categories'), function()
        {
            Route::get('/', 'Admin_SubjectCategoryController@getIndex');

            Route::get('/create', 'Admin_SubjectCategoryController@getCreate');
            Route::post('/create', 'Admin_SubjectCategoryController@postCreate')->before('csrf');

            Route::get('/{subjectcategory}/edit', 'Admin_SubjectCategoryController@getEdit');
            Route::post('/{subjectcategory}/edit', 'Admin_SubjectCategoryController@postEdit')->before('csrf');

            Route::get('/{subjectcategory}/view', 'Admin_SubjectCategoryController@getView');

            Route::get('/delete', 'Admin_SubjectCategoryController@getDelete')->before('csrf');

            Route::get('/export', 'Admin_SubjectCategoryController@getExport')->before('csrf');
            Route::get('/search-select', 'Admin_SubjectCategoryController@getSearchSelect')->before('csrf');
        });
    });

}); // ./end group (prefix=conf('admin::uri'))
