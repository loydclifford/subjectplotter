<?php

if ( ! function_exists('user_check'))
{
    /**
     * Yet another version of auth check
     *
     * @return bool
     */
    function user_check()
    {
        return Auth::check();
    }
}

if ( ! function_exists('user_guest'))
{

    /**
     * Yet another version of auth guest
     *
     * @return mixed
     */
    function user_guest()
    {
        return Auth::guest();
    }
}


if ( ! function_exists('user_get'))
{

    /**
     * Yet another version of auth get
     *
     * @return mixed
     */
    function user_get()
    {
        return Auth::user();
    }
}

if ( ! function_exists('can'))
{

    /**
     * Yet another version of auth get
     *
     * @return mixed
     */
    function can($capability, $default = null)
    {
        return true;
    }
}


