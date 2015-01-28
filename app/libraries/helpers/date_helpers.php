<?php


function seconds2Weeks($seconds) {
    $WEEKS = "%d day(s)";
    $DAYS = "%d week(s)";

    $minutes = $seconds / 60;
    $hours = $minutes / 60;
    $days = $hours / 24;
    $weeks = $days / 7;

    if ($days < 7)
    {
        $words = sprintf($DAYS,$days);
    } else if ($weeks > 0){
        $words = sprintf($WEEKS,$weeks);
    }

    return $words;

}
