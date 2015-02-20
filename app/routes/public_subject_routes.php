<?php


Route::group(array('before'=>'student_auth'), function() {
    Route::get('/subject/search-select', 'Public_SubjectController@getSearchSelect' );
});