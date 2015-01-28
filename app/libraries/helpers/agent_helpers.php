<?php

/**
 * Get the domain referrer if $just_domain param is true
 * , else get the full referrer uri
 *
 * @param bool $just_domain
 * @return mixed|string
 */
function get_referrer($just_domain= false) {
    $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER']: "/";

    // remove http or s, remove www and /
    if ($just_domain)
    {
        $ref = preg_replace("/http:\/\//i", "", $ref);
        $ref = preg_replace("/^www\./i", "", $ref );
        $ref = preg_replace("/\/.*/i", "", $ref );
        return $ref;
    }
    else
    {
        return $ref;
    }
}


/**
 * This will just get the client ip, for logging purposes
 * @return string|null
 */
function client_ip(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "";
    }

    return $ip;
}