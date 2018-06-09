<?php

namespace richardevcom\PHPHelpers;

/**
 * Replace special characters
 * @param string $string String to filter
 * @param mixed $replace Replacement for special chars. Default '' will remove characters.
 * @return string
 */
function schars_replace($string, $replace = ''){
	$string = str_replace("'", $replace, $string);
	return preg_replace('/[^a-zA-Z0-9\']/', $replace, $string);
}

/**
 * Replace string values multiple times from array values
 * @param array $array List of needles to use
 * @param string $subject String to filter
 * @return string|bool
 */
function multi_str_replace($array, $subject){
	if(is_array($array)){
		foreach ($array as $key => $value) {
			$subject = str_replace($key, $value, $subject);
		}
		return $subject;
	}
	return false;
}

/**
 * Check if string starts with "*" character
 * @param string $search Characters to search for
 * @param string $string String to check
 * @return string
 */
function str_starts_with($search, $string){
	return (substr($string, 0, strlen($string)) === $search);
}

/**
 * Check if string starts with "*" character CASE INSENSITIVE
 * @param string $search Characters to search for
 * @param string $string String to check
 * @return string
 */
function istr_starts_with($search, $sting){
	return str_starts_with(strtolower($search), strtolower($string));
}

/**
 * Check if string ends with "*" character
 * @param string $search Characters to search for
 * @param string $string String to check
 * @param bool $sensitive Use case sensitive search?
 * @return string
 */
function str_ends_with($search, $string){
	$length = strlen($search);
    return $length === 0 || (substr($string, -$length) === $search);
}

/**
 * Check if string ends with "*" character CASE INSENSITIVE
 * @param string $search Characters to search for
 * @param string $string String to check
 * @return string
 */
function istr_ends_with($search, $string){
    return str_ends_with(strtolower($search), strtolower($string));
}

/**
 * Check if a string contains a substring
 *
 * @param string $search
 * @param string $string
 * @return boolean
 */
function str_contains($search, $string){
    return strpos($search, $string) !== false;
}

/**
 * Extract string before characters
 * @param string $search Characters before to cut
 * @param string $string String to check
 * @return string
 */
function str_before($search, $string) {
	if(!$sensitive){
		$string = strtolower($string);
		$search = strtolower($search);
	}
	$result =	substr($string, 0, strpos($string, $search));

	if($result) return $result;
	return $string;
}

/**
 * Extract string before characters CASE INSENSITIVE
 * @param string $search Characters before to cut
 * @param string $string String to check
 * @return string
 */
function istr_before($search, $string) {
	$string = strtolower($string);
	$search = strtolower($search);

	return str_before($search, $string);
}

/**
 * Extract string after characters
 * @param string $search Characters after to cut
 * @param string $string String to check
 * @return string
 */
function str_after($search, $string){
	$result = substr($string, strpos($string, $search) + strlen($search));

	if($result) return $result;
	return $string;
}

/**
 * Extract string after characters CASE INSENSITIVE
 * @param string $search Characters after to cut
 * @param string $string String to check
 * @return string
 */
function istr_after($search, $string){
	$string = strtolower($string);
	$search = strtolower($search);
	return str_after($search, $string);
}

/**
 * Add string before characters found
 * @param string $search Characters to filter
 * @param string $replace Replacement string
 * @param string $string String to filter
 * @return string
 */
function str_add_before($search, $replace, $string){
	return str_replace($search, $replace.$search, $string);
}

/**
 * Add string before characters found  CASE INSENSITIVE
 * @param string $search Characters to filter
 * @param string $replace Replacement string
 * @param string $string String to filter
 * @return string
 */
function istr_add_before($search, $replace, $string){
	if($sensitive) return str_ireplace($search, $replace.$search, $string);
}

/**
 * Add string after characters found
 * @param string $search Characters to filter
 * @param string $replace Replacement string
 * @param string $string String to filter
 * @return string
 */
function str_add_after($search, $replace, $string){
	return str_replace($search, $search.$replace, $string);
}

/**
 * Add string after characters found CASE INSENSITIVE
 * @param string $search Characters to filter
 * @param string $replace Replacement string
 * @param string $string String to filter
 * @return string
 */
function istr_add_after($search, $replace, $string){
	return str_ireplace($search, $search.$replace, $string);
}

/**
 * Generates a random string
 * @param int $length String length
 * @param string $string Generate string from these characters
 * @return string
 */
function str_random($length = 16, $chars = ''){
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ`~!@#$%^&*()-=_+[]{}\\|;:\'",.<>/?';
    if($chars)  $pool = $chars;
    if(strlen($pool) < $length){
    	$pool = str_repeat($pool, rand(1, $length / 2));
    }
    return substr(str_shuffle($pool), rand(1, $length / 2), $length);
}

/**
 * Remove every occurance of word in string
 * @param string $search String to search for
 * @param string $strubg Strubg to filter
 * @return string
 */
function str_remove($search, $string){
	if (! empty($string) && ! empty($search)) {
        if (strpos($string, $search) !== false) {
            return str_replace($search, '', $string);
        }
    }
    return $string;
}

/**
 * Check if string matches a given pattern.
 * @param  string $search
 * @param  string $string
 * @return bool
 */
function str_is($search, $string) {
    if ($string == $search) {
        return true;
    }
    $string = preg_quote($string, '#');

    $string = str_replace('\*', '.*', $string);
    return (bool) preg_match('#^' . $string . '\z#u', $search);
}

function password($length = 16, $add_dashes = false, $available_sets = 'auns'){
	$sets = array();
	if(strpos($available_sets, 'a') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'n') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';

	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}

	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];

	$password = str_shuffle($password);

	if(!$add_dashes)
		return $password;

	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}

/**
 * Truncates $string to a preferred length
 * @param  string  $str    the string to truncate
 * @param  int     $limit  the string's max length
 * @param  string  $break  the break character (to truncate at exact length set to 
 *    empty string or null) (if the break character does not exist in the string, 
 *    the string will be truncated at limit) (optional; if omitted, defaults to ' ') 
 * @param  string  $pad    the padding to add to end of string (optional; if 
 *    omitted, defaults to '...')
 *
 * @return  string  the truncated string
 */
function truncate($string, $limit, $break = ' ', $pad = '...') {
	$truncated = null;
	
	// if $string and $limit are given
	if ($string !== null && $limit !== null) {
		// if $string is actually a string
		if (is_string($string)) {
			// if $limit is a number
			if (is_numeric($limit) && is_int(+$limit)) {
				// if $break is a string or it's null
				if (is_string($break) || is_null($break)) {
					// if $pad is a string or it's null
					if (is_string($pad) || is_null($pad)) {
						// if $string is longer than $limit
						if (strlen($string) > $limit) {
							// truncate the string at the limit
							$truncated = substr($string, 0, $limit);
							// if a break character is defined and it exists in the truncated string
							if ($break !== null && $break !== '' && strpos($truncated, $break)) {
								$truncated = substr($truncated, 0, strrpos($truncated, $break));
							}
							// if a pad exists, use it
							if ($pad !== null && $pad !== '') {
								$truncated .= $pad;
							}
						} else {
							$truncated = $string;
						}
					}
				}
			}
		}
	}
	return $truncated;
}