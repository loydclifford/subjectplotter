<?php

// META HELPER

function db2array_value($meta_value)
{
    // Check if meta_value can be serialized or not,
    // if it is then set meta value to the unserialize value
    // else, just use its value
    $unserialize = @unserialize($meta_value);

    // Bug fixed: return false when unserialize variable return empty array
    // we need to force unserialize to return empty array rather than
    // its original value.
    $meta_value = $unserialize || is_array($unserialize) ? $unserialize : $meta_value;

    if (is_int($meta_value))
    {
        return (int) $meta_value;
    }
    else
    {
        return $meta_value;
    }
}

function array2db_value($meta_value)
{
    $serializeable = is_array($meta_value) || is_object($meta_value);
    return $serializeable ? serialize($meta_value) : $meta_value;
}


function meta_cached_name($table,$id,$meta_name) {
    return 'meta_key_'.$meta_name.'_'.$table.'_'.$id;
}

// Start meta specific to tables


// Specific for user META
//
//
//function create_usermeta($user_id,$meta_key,$meta_value) {
//
//    // remove cached ' meta_key_(met_aa_name)_(userid)
//    Cache::forget( meta_cached_name('users',$user_id,$meta_key) );
//
//    $is_exists = Usermeta::where('meta_key','=',$meta_key)
//        ->where('user_id','')->first();
//
//    if ($is_exists)
//    {
//        $meta = $is_exists;
//    }
//    else
//    {
//        $meta = new Usermeta();
//    }
//
//    $meta->user_id      = $user_id;
//    $meta->meta_key     = $meta_key;
//    $meta->meta_value   = array2db_value($meta_key) ;
//    $meta->save();
//}
//
//function update_usermeta($user_id,$meta_key,$meta_value) {
//    create_usermeta($user_id,$meta_key,$meta_value);
//}
//
//function get_usermeta($user_id,$meta_key,$default_value = false) {
//
//    $meta = Usermeta::where('meta_key','=',$meta_key)
//        ->remember( 2000, meta_cached_name('users',$user_id,$meta_key))
//        ->first();
//
//    if (!$meta) return $default_value;
//
//    return $meta;
//}
//
//function get_usermeta_value($user_id,$meta_key,$default = "") {
//    $meta = get_usermeta($user_id,$meta_key);
//
//    return $meta ? db2array_value($meta->meta_value) : $default;
//}
//
//
//
