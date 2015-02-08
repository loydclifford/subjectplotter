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


function getMonths()
{
    return array(
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    );
}

function getDays()
{
    $ret = array();

    for ($i=1;$i<=31;$i++)
    {
        $ret[$i] = $i;
    }

    return $ret;
}