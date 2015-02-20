<?php


Route::group(array('before'=>'student_auth'), function() {
    Route::get('/subject/search-select', 'Public_SubjectController@getSearchSelect' );
    Route::get('/subject/getRemove', 'Public_SubjectController@getRemove' );
    Route::get('/subject/load-default', 'Public_SubjectController@getLoadDefaults' );
    Route::post('/subject/add-subject', 'Public_SubjectController@postAddSubject' );
    Route::post('/subject/submit-plotting', 'Public_SubjectController@postSubmitPlotting' );
});