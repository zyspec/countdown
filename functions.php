<?php

//This function is code borrowed from xhelp.
/**
 * @param $time
 * @return string
 */
function countdownFormatTime($time)
{
    $values = countdownGetElapsedTime($time);

    foreach ($values as $key => $value) {
        $$key = $value;
    }

    $ret = [];
    if ($years) {
        $ret[] = $years . ' ' . (1 == $years ? _COUNTDOWN_TIME_YEAR : _COUNTDOWN_TIME_YEARS);
    }

    if ($weeks) {
        $ret[] = $weeks . ' ' . (1 == $weeks ? _COUNTDOWN_TIME_WEEK : _COUNTDOWN_TIME_WEEKS);
    }

    if ($days) {
        $ret[] = $days . ' ' . (1 == $days ? _COUNTDOWN_TIME_DAY : _COUNTDOWN_TIME_DAYS);
    }

    if ($hours) {
        $ret[] = $hours . ' ' . (1 == $hours ? _COUNTDOWN_TIME_HOUR : _COUNTDOWN_TIME_HOURS);
    }

    if ($minutes) {
        $ret[] = $minutes . ' ' . (1 == $minutes ? _COUNTDOWN_TIME_MIN : _COUNTDOWN_TIME_MINS);
    }

    $ret[] = $seconds . ' ' . (1 == $seconds ? _COUNTDOWN_TIME_SEC : _COUNTDOWN_TIME_SECS);

    if (($years < 0) || ($weeks < 0) || ($days < 0) || ($hours < 0) || ($minutes < 0) || ($seconds < 0)) {
        return 'Expired';
    } else {
        return implode(', ', $ret);
    }
}

/**
 * @param $time
 * @return array
 */
function countdownGetElapsedTime($time)
{
    //Define the units of measure
    $units = [
        'years'   => 365 * 60 * 60 * 24 /*Value of Unit expressed in seconds*/,
        'weeks'   => 7 * 60 * 60 * 24,
        'days'    => 60 * 60 * 24,
        'hours'   => 60 * 60,
        'minutes' => 60,
        'seconds' => 1
    ];

    $local_time   = $time;
    $elapsed_time = [];

    //Calculate the total for each unit measure
    foreach ($units as $key => $single_unit) {
        $elapsed_time[$key] = floor($local_time / $single_unit);
        $local_time         -= ($elapsed_time[$key] * $single_unit);
    }

    return $elapsed_time;
}
