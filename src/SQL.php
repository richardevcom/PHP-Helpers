<?php

namespace richardevcom\PHPHelpers;

/**
 * Return MySQL timestamp formated date/time
 * @param int $time The time integer. Default time()
 * @return string Returns formated date
 */
function mysql_timestamp($time = 0){
	$time ? false : $time = time();
	return date("Y-m-d H:i:s", $time);
}

/**
 * Returns true if $number is a valid database id (aka, unsigned int)
 * @param  int|float  $number    the number to test
 * @param  string     $datatype  the column datatype name (possible values are
 *    'tiny[int]', 'small[int]', 'medium[int]', 'int[eger]', and 'big[int]') 
 *    (case-insensitive) (optional; if omitted, defaults to 'int')
 * @return  bool  true if the number is a valid database id
 */
function is_id($number, $datatype = 'int') {
	$is_id = false; 
	
	// if $datatype is not null
	if ($datatype !== null) {
		// if $datatype is a string
		if (is_string($datatype)) {
			// if $number is actually a number
			if (is_numeric($number)) {
				// if the number is a positive integer
				if (is_int($number) && $number > 0) {
					// if the number is LTE the datatype's max value
					switch (strtolower($datatype)) {
						case 'tiny':
						case 'tinyint':
							$is_id = ($number <= 255);
							break;
						
						case 'small':
						case 'smallint':
							$is_id = ($number <= 65535);
							break;
						
						case 'medium':
						case 'mediumint':
							$is_id = ($number <= 8388607);
							break;
						
						case 'int':
						case 'integer':
							$is_id = ($number <= 4294967295);
							break;
						
						case 'big':
						case 'bigint':
							// cast the datatype's maximum value to a float
							// the integer's size is beyond PHP's maximum integer value
							//
							$is_id = ($number <= (float) 18446744073709551615);
							break;
					
						default:
							return false;
					}
				}
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
	
	return $is_id;
}