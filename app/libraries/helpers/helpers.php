<?php

if ( ! function_exists('lang'))
{

    /**
     * another version of Lang::get
     *
     * @param  string  $lang_line
     * @return mixed
     */
    function lang($lang_line, $replace = array(), $locale = null)
    {
        return Lang::get($lang_line, $replace, $locale);
    }
}

if ( ! function_exists('torf'))
{

    /**
     * Return the word true or false, if the passed parameter
     * return true or false
     *
     * @param  string  $bool
     * @return mixed
     */
    function torf($bool)
    {
        if ($bool)
        {
            return "true";
        }
        else
        {
            return "false";
        }
    }
}


if ( ! function_exists('conf'))
{

    /**
     * Yet another version of auth guest
     *
     * @param  string  $config
     * @return mixed
     */
    function conf($config)
    {
        return Config::get($config);
    }
}

/**
 * Prefix url with admin url base
 *
 * @param string    $path
 * @param array     $parameters - url parameters
 * @param bool      $secure - Boolean
 * @return string
 */
function admin_url($path = '', $parameters = array(), $secure = null)
{
    return URL::to("admin" . $path,$parameters,$secure);
}

/**
 * Get the admin logout url
 *
 * @return mixed
 */
function admin_logout_url() {
    return admin_url("/logout/?_token=" . urlencode(Session::get('_token')));
}

/**
 * Custom Asset URL.
 * Here we can define where does our assets
 * Note: that this function will only handle the uri directory and file
 * it is assume that you only passed '/js/something.js'
 * use URL::to or URL::asset directly instead.
 *
 * @param string $path
 * @param null $secure
 * @param null $basePath
 * @return string
 */
function asset_url($path = '', $secure = NULL, $basePath = NULL)
{
    $basePath = ! empty($basePath) ?: '/assets';
    return URL::asset($basePath.$path, $secure);
}

/**
 * Yet another version of auth guest
 *
 * @param string    $path
 * @param array     $parameters
 * @param bool      $secure
 * @return string
 */
function public_url($path = '', $parameters = array(), $secure = null)
{
    return URL::to($path, $parameters, $secure);
}

/**
 * Generate a route url
 *
 * @param string $path
 * @return string
 */
function admin_path($path = '')
{
    return "admin" . $path;
}



if ( ! function_exists('is_closure'))
{
    /**
     * Check if the given value is a valid closure
     *
     * @param $t
     * @return bool
     */
    function is_closure($t)
    {
        return is_object($t) && ($t instanceof Closure);
    }
}

if ( ! function_exists('real_file_name'))
{
    function real_file_name($file_name)
    {
        if (strpos($file_name,'.blade.php') !== FALSE)
        {
            return str_replace('.blade.php','',$file_name);
        }

        if (strpos($file_name,'.php') !== FALSE)
        {
            return str_replace('.php','',$file_name);
        }

        return NULL;
    }
}

if ( ! function_exists('beauty_name'))
{
    function beauty_name($file_name)
    {
        $file_name = str_replace('_',' ', $file_name);
        $file_name = str_replace('-',' ', $file_name);
        return Str::title($file_name);
    }
}
if ( ! function_exists('unsetv'))
{
    function unsetv( & $array,$val_to_del)
    {
        if(($key = array_search($val_to_del, $array)) !== false) {
            unset($array[$key]);
        }
    }
}

if ( ! function_exists('array_search_kv'))
{
    /**
     * Searches the array for a given key and value and returns the corresponding key if successful
     *
     * @param $child_key
     * @param $child_value
     * @param $array
     * @return mixed
     */
    function array_search_kv($array_key,$array_value,$array_data)
    {
        foreach($array_data as $key => $item)
        {
            if (isset($item[$array_key]))
            {
                if ($item[$array_key] === $array_value)
                {
                    return $key;
                }
            }
        }

        return false;
    }
}

/**
 * This file is part of the array_column library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) 2013 Ben Ramsey <http://benramsey.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
if (!function_exists('array_column')) {
    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     * a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     * integer key of the column you wish to retrieve, or it
     * may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     * the returned array. This value may be the integer key
     * of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
// Using func_get_args() in order to check for proper number of
// parameters and trigger errors exactly as the built-in array_column()
// does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if (!is_array($params[0])) {
            trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
            return null;
        }
        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }
        $resultArray = array();
        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;
            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }
            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }
            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }
        }
        return $resultArray;
    }
}

if ( ! function_exists('array_column2'))
{
    /**
     * Searches the array for a given key and value and returns the corresponding key if successful
     *
     * @param $child_key
     * @param $child_value
     * @param $array
     * @return mixed
     */
    function array_column2($array,$column_key,$index_key = false)
    {
        $ret = array();

        if (is_object($array))
        {

            // If an instance of laravel
            if (is_callable(array($array,'toArray'),true,$callable))
            {
                $array = $array->toArray();
            }
            else
            {
                $array = (array) $array;
            }
        }


        foreach($array as $item)
        {
            if (isset($item[$column_key]))
            {
                if ( $index_key && isset($item[$index_key]))
                {
                    $ret[$item[$index_key]] = $item[$column_key];
                }
                else
                {
                    $ret[] = $item[$column_key];
                }
            }
        }

        return $ret;
    }
}

if ( ! function_exists('preg_quote_recursive'))
{
    /**
     * Preg quote recursively
     *
     * @param $child_key
     * @param $child_value
     * @param $array
     * @return mixed
     */

    /**
     * @param $array
     * @return array - Original array return array
     */
    function preg_quote_recursive($array)
    {
        if (is_array($array))
        {
            $ret = array();

            foreach($array as $key=>$value)
            {
                $value = preg_quote_recursive($value);

                $ret[$key] = $value;
            }
        }
        else
        {
            $ret = preg_quote($array);
        }

        return $ret;
    }
}

if ( ! function_exists('urlencode_recursive'))
{

    /**
     * Convert string to url encoded recursively
     *
     * @param $array
     * @return array - Original array return array
     */
    function urlencode_recursive($array)
    {
        if (is_array($array))
        {
            $ret = array();

            foreach($array as $key=>$value)
            {
                $value = urlencode_recursive($value);

                $ret[$key] = $value;
            }
        }
        else
        {
            $ret = urlencode($array);
        }

        return $ret;
    }
}

if ( ! function_exists('to_attr'))
{
    /**
     * Convert array to html attributes.
     *
     * @param array $arr
     * @return null|string
     */
    function to_attr(array $arr = array())
    {
        if (!is_array($arr))
        {
            return NULL;
        }

        $ret = "";
        foreach($arr as $attr => $value)
        {
            $ret .= $attr . '="' . e($value) . '" ';
        }

        return $ret;
    }

}

if ( ! function_exists('p_token_string'))
{
    /**
     * Url parameter token string
     *
     * @return string
     */
    function p_token_string()
    {
        return '_token='.Session::get('_token');
    }
}

if ( ! function_exists('unset_by_value'))
{
    /**
     * Url parameter token string
     *
     * @return string
     */
    function unset_by_value($value, $arrays)
    {
        if(($key = array_search($value, $arrays)) !== false) {
            unset($arrays[$key]);
        }

        return $arrays;
    }
}

if ( ! function_exists('prefix_array_keys'))
{
    /**
     * Prefix array keys
     *
     * @param string    $prefix
     * @param array     $array
     * @return array
     */
    function prefix_array_keys($prefix, array $array = array())
    {
        $prefixed_array = array();
        foreach ($array as $k => $v)
        {
            $prefixed_array[$prefix.$k] = $v;
        }

        return $prefixed_array;
    }
}

