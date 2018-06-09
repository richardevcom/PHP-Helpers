<?php

namespace richardevcom\PHPHelpers;

/**
 * Return a DateTimeZone object based on the current timezone.
 *
 * @param mixed $timezone
 * @return \DateTimeZone
 */
function timezone($timezone = null): \DateTimeZone {
    if ($timezone instanceof \DateTimeZone) {
        return $timezone;
    }
    $timezone = $timezone ?: date_default_timezone_get();
    return new \DateTimeZone($timezone);
}

/**
 * Check if string is date
 *
 * @param string $date
 * @return bool
 */
function is_date($date): bool {
    $time = strtotime($date);
    return $time > 0;
}

/**
 * Convert to human readable date
 * @param string|int $date
 * @param string     $format
 * @return string
 */
function date_r($date, $format = 'd M Y H:i'): string {
    return datetime($date)->datetime($format);
}

/**
 * Datetime helper function
 * @param mixed $time
 * @param null  $timezone
 * @return DateTime
 */
function datetime($time = null, $timezone = null): \DateTime {
    if(function_exists('\richardevcom\phphelpers\timestamp')){
	    $timezone = timezone($timezone);
	    if ($time instanceof \DateTime) {
	        return $time->setTimezone($timezone);
	    }
    	$dateTime = new \DateTime('@' . timestamp($time));
	    $dateTime->setTimezone($timezone);
	    return $dateTime;
    }else{
    	throw new \Exception("Function timestamp() is missing - datetime() requires this function.");
    }
}

/**
 * Returns true if date passed is within this week.
 *
 * @param string|int $time
 * @return bool
 */
function is_this_week($time): bool {
    return (datetime($time)->format('W-Y') === datetime()->format('W-Y'));
}

/**
 * Returns true if date passed is within this month.
 *
 * @param string|int $time
 * @return bool
 */
function is_this_month($time): bool {
    return (datetime($time)->datetime('m-Y') === datetime()->format('m-Y'));
}
/**
 * Returns true if date passed is within this year.
 *
 * @param string|int $time
 * @return bool
 */
function is_this_year($time): bool {
    return (datetime($time)->format('Y') === datetime()->format('Y'));
}
/**
 * Returns true if date passed is tomorrow.
 *
 * @param string|int $time
 * @return bool
 */
function is_tomorrow($time): bool {
    return (datetime($time)->format('Y-m-d') === datetime('tomorrow')->format('Y-m-d'));
}
/**
 * Returns true if date passed is today.
 *
 * @param string|int $time
 * @return bool
 */
function is_today($time): bool {
    return (datetime($time)->format('Y-m-d') === datetime()->format('Y-m-d'));
}
/**
 * Returns true if date passed was yesterday.
 *
 * @param string|int $time
 * @return bool
 */
function is_yesterday($time): bool {
    return (datetime($time)->format('Y-m-d') === datetime('yesterday')->format('Y-m-d'));
}