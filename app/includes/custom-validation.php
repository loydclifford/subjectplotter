<?php


// Australian Company Number (ACN)
Validator::extend('terms_condition', function($attribute, $value, $parameters)
{
    // Provider number format is invalid.
    // '4024742F' is valid.
    return !empty($value) && $value == 1;
});

// Australian Company Number (ACN)
Validator::extend('password', function($attribute, $value, $parameters)
{
    // Provider number format is invalid.
    // '4024742F' is valid.
    return preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,16}$/', $value);
});

// Australian Company Number (ACN)
Validator::extend('username', function($attribute, $value, $parameters)
{
    // Provider number format is invalid.
    // '4024742F' is valid.
    return preg_match('/^[a-z0-9_-]{3,15}$/', $value);
});

// Australian Company Number (ACN)
Validator::extend('money', function($attribute, $value, $parameters) {

    $value = str_replace(",",'',$value);
    $value = str_replace("$",'',$value);
    $value = str_replace(" ",'',$value);

    return is_numeric($value);
});

Validator::extend('login_email',function($attribute, $value, $parameters){
    return User::where('email','=',$value)->first() ? true : false;
});

Validator::extend('registration_not_in',function($attribute, $value, $parameters){
    return !in_array($value,$parameters);
});

Validator::extend('location_place_id',function($attribute, $value, $parameters){
    $details = Utils::getPlacesDetails($value);

    return ! empty($details);
});
