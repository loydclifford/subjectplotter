<?php


Route::model('user','User');
Route::model('room','Room');
Route::model('subject','Subject');
Route::model('course','Course');
Route::model('course_year','CourseYear');
Route::model('instructor','Instructor');

include(__DIR__.'/routes/admin_routes.php');
include(__DIR__.'/routes/users_routes.php');
include(__DIR__.'/routes/rooms_routes.php');
include(__DIR__.'/routes/subjects_routes.php');
include(__DIR__.'/routes/courses_routes.php');
include(__DIR__.'/routes/course_years_routes.php');
include(__DIR__.'/routes/instructors_routes.php');
include(__DIR__.'/routes/settings_routes.php');
include(__DIR__.'/routes/subjectschedules_routes.php');
include(__DIR__.'/routes/subjectschedulesetschedules_routes.php');
include(__DIR__.'/routes/subjectcategories_routes.php');


define('ENV_DEVELOPMENT', 'local');
define('ENV_STAGING', 'staging');
define('ENV_PRODUCTION', 'production');
define('ENV_STAGING_SITE', 'staging_site');
define('REX_LOCAL', 'rex_local');

define('FORCE_PUBLIC_BASE_VIEW', '_force_public_base_view');

define('SESSION_TIMEZONE', 'timezone');
define('SESSION_CURRENCY', 'currency');
define('SESSION_DATE_FORMAT', 'dateFormat');
define('SESSION_DATE_PICKER_FORMAT', 'datePickerFormat');
define('SESSION_TIME_FORMAT', 'timeFormat');
define('SESSION_COUNTER', 'sessionCounter');
define('SESSION_LOCALE', 'sessionLocale');
define('SESSION_GATEWAY_PROVIDER', '_session_gateway_provider');

define('DB_DATE_FORMAT', 'Y-m-d');
define('DB_DATETIME_FORMAT', 'Y-m-d H:i:s');

define('DEFAULT_QUERY_CACHE', 120); // minutes
define('DEFAULT_CACHE_MINUTES', 120); // minutes

define('RESULT_SUCCESS', 'success');
define('RESULT_FAILURE', 'failure');
define('RESULT_INVALID_TOKEN', 'invalid_token');
define('RESULT_NOT_LOG_IN', 'not_logged_in');
define('SUCCESS_MESSAGE', '_success_message');
define('INFO_MESSAGE', '_info_message');
define('ERROR_MESSAGE', '_error_message');