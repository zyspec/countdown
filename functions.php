<?php

	//This function is code borrowed from xhelp.
	function countdownFormatTime($time)
	{
	    $values = countdownGetElapsedTime($time);
	    
	    foreach($values as $key=>$value) {
	        $$key = $value;
	    }
	    
	    $ret = array();
	    if ($years) {
	        $ret[] = $years . ' ' . ($years == 1 ? _COUNTDOWN_TIME_YEAR : _COUNTDOWN_TIME_YEARS);
	    }
	    
	    if ($weeks) {
	        $ret[] = $weeks . ' ' . ($weeks == 1 ? _COUNTDOWN_TIME_WEEK : _COUNTDOWN_TIME_WEEKS);
	    }
	        
	    if ($days) {
	        $ret[] = $days . ' ' . ($days == 1 ? _COUNTDOWN_TIME_DAY : _COUNTDOWN_TIME_DAYS);
	    }
	    
	    if ($hours) {
	        $ret[] = $hours . ' ' . ($hours == 1 ? _COUNTDOWN_TIME_HOUR : _COUNTDOWN_TIME_HOURS);
	    }
	    
	    if ($minutes) {
	        $ret[] = $minutes . ' ' . ($minutes == 1 ? _COUNTDOWN_TIME_MIN : _COUNTDOWN_TIME_MINS);
	    }
	    
	    $ret[] = $seconds . ' ' . ($seconds == 1 ? _COUNTDOWN_TIME_SEC : _COUNTDOWN_TIME_SECS);
	    
	    if (($years < 0) || ($weeks < 0) || ($days < 0) || ($hours < 0) || ($minutes < 0) || ($seconds < 0))
	    {
	    	return "Expired";
	    }
	    else
	    {
	    	return implode(', ', $ret);
	    }
	}
	        
	function countdownGetElapsedTime($time)
	{    
	    //Define the units of measure
	    $units = array('years' => (365*60*60*24) /*Value of Unit expressed in seconds*/,
	        'weeks' => (7*60*60*24),
	        'days' => (60*60*24),
	        'hours' => (60*60),
	        'minutes' => 60,
	        'seconds' => 1);
	    
	    $local_time   = $time;  
	    $elapsed_time = array();
	    
	    //Calculate the total for each unit measure
	    foreach($units as $key=>$single_unit) {
	        $elapsed_time[$key] = floor($local_time / $single_unit);
	        $local_time -= ($elapsed_time[$key] * $single_unit);
	    }
	    
	    return $elapsed_time;
	}
?>