<?php



// Below is a media helpers



/**
 * Retrieve media type.
 *
 * @param  string  $ext
 * @return string
 */
function media_type($ext)
{

    $img_mimes = array('jpg', 'jpeg', 'gif', 'png');

    if (in_array($ext, $img_mimes))
    {

        $t = 'img';

    } else {

        $t = $ext;

    }

    return $t;

}

function is_image($mime) {
    $img_mimes = array('jpg', 'jpeg', 'gif', 'png');

    if (in_array($mime,$img_mimes))
    {
        return true;
    } else {
        return false;
    }
}

function to_size_name($size) {
    $b = $size . "B";
    $kb = round($b / 1024,2) . " KB ";
    $mb = round($kb / 1024,2) . " MB ";
    $gb = round($mb / 1024,2) . " GB";

    if ($kb < 1)
    {
        return $b;
    }
    elseif ( $mb < 1)
    {
        return $kb;
    }
    elseif( $gb < 1) {
        return $mb;
    }

    return $gb;
}


/**
 * Convert int text to formatted file size
 *
 * @param  int
 * @param  string
 * @return string
 */
function media_size($size, $type = 'MB')
{
    switch($type) {
        case "KB":
            $filesize = $size * .0009765625; // bytes to KB
            break;
        case "MB":
            $filesize = ($size * .0009765625) * .0009765625; // bytes to MB
            break;
        case "GB":
            $filesize = (($size * .0009765625) * .0009765625) * .0009765625; // bytes to GB
            break;
    }

    if($filesize < 0)
    {
        return $filesize = 'unknown file size';}
    else {
        return round($filesize, 2).' '.$type;
    }
}


/**
 * Remove extension
 *
 * @param  string
 * @return string
 */
function meadia_no_ext($path)
{
    return substr($path, 0, -4);
}


/**
 * Remove point of extension
 *
 * @param  string
 * @return string
 */
function media_no_point($path)
{
    return str_replace('.', '', $path);
}


function is_video($type = "")
{
    // @todo add video condition here
    return FALSE;
}

function ext_mime($key,$by_value = false)
{
    $mime_types = array(
        "pdf"=>"application/pdf",
        "exe"=>"application/octet-stream",
        "zip"=>"application/zip",
        "docx"=>"application/msword",
        "doc"=>"application/msword",
        "xls"=>"application/vnd.ms-excel",
        "ppt"=>"application/vnd.ms-powerpoint",
        "gif"=>"image/gif",
        "png"=>"image/png",
        "jpeg"=>"image/jpeg",
        "jpg"=>"image/jpg",
        "mp3"=>"audio/mpeg",
        "wav"=>"audio/x-wav",
        "mpeg"=>"video/mpeg",
        "mpg"=>"video/mpeg",
        "mpe"=>"video/mpeg",
        "mp4"=>"video/mp4",
        "mov"=>"video/quicktime",
        "avi"=>"video/x-msvideo",
        "3gp"=>"video/3gpp",
        "css"=>"text/css",
        "jsc"=>"application/javascript",
        "js"=>"application/javascript",
        "php"=>"text/html",
        "htm"=>"text/html",
        "html"=>"text/html",
    );

    if ($by_value)
    {
        foreach ($mime_types as $mime_key=>$value)
        {
            if ($value == $key)
            {
                return $mime_key;
            }
        }
    }
    else
    {
        return isset($mime_types[$key]) ? $mime_types[$key] : NULL;
    }

    return NULL;
}

function ext_mime_image()
{
    return array(
        "gif"=>"image/gif",
        "png"=>"image/png",
        "jpeg"=>"image/jpg",
        "jpg"=>"image/jpg"
    );
}

function ext_mime_video()
{
    return array(
        "wav"=>"audio/x-wav",
        "mpeg"=>"video/mpeg",
        "mpg"=>"video/mpeg",
        "mpe"=>"video/mpeg",
        "mp4"=>"video/mp4",
        "mov"=>"video/quicktime",
        "avi"=>"video/x-msvideo",
        "3gp"=>"video/3gpp"
    );
}

function ext_mime_audio()
{
    return array(
        "mp3"=>"audio/mpeg",
        "wav"=>"audio/x-wav",
    );
}

function ext_is_video($key = 'whatever')
{
    $ext = ext_mime_video();

    return array_key_exists($key,$ext);
}

function ext_is_audio($key = 'whatever')
{
    $ext = ext_mime_audio();

    return array_key_exists($key,$ext);
}

function ext_is_image($key = 'whatever')
{
    $ext = ext_mime_image();

    return array_key_exists($key,$ext);
}


function mime_is_video($key = 'whatever')
{
    $ext = ext_mime_video();

    return in_array($key,$ext);
}

function mime_is_audio($key = 'whatever')
{
    $ext = ext_mime_audio();

    return in_array($key,$ext);
}

function mime_is_image($key = 'whatever')
{
    $ext = ext_mime_image();

    return in_array($key,$ext);
}