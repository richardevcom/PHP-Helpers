<?php

namespace richardevcom\PHPHelpers;

/**
 * Returns $bool value in the string $format
 *
 * I'll return a bool value as a true-false, yes-no, or on-off string.
 *
 * For example:
 *
 *     Bool::booltostr(true);             // returns (string) 'true'
 *     Bool::booltostr(true, 'yes-no');   // returns (string) 'true'
 *     Bool::booltostr(false, 'on-off');  // returns (string) 'off'
 *
 * @since  0.1.0
 *
 * @param  bool    $bool    the boolean value to convert
 * @param  string  $format  the string format to convert to (possible values are
 *    't[/-]f', true[/-]false', 'y[/-]n', 'yes[/-]no', 'o[/-o]', and 'on[/-]off')
 *    (case-insensitive) (optional; if omitted, defaults to 'true-false')
 *
 * @return  string  the string value
 *
 * @throws  \BadMethodCallException    if $bool is null
 * @throws  \InvalidArgumentException  if $bool is not a (bool) value
 * @throws  \InvalidArgumentException  if $format is not a string
 * @throws  \InvalidArgumentException  if $format is not a valid format
 */
function booltostr($bool, $format = 'true-false') {
	$string = false;
	
	// if $bool and format are not null
	if ($bool !== null && $format !== null) {
		// if $bool is actually a bool
		if (is_bool($bool)) {
			// if $format is a string
			if (is_string($format)) {
				// switch on the lower-case $format
				switch (strtolower($format)) {
					
					case 'oo':
					case 'o/o':
					case 'o-o':
					case 'onoff':
					case 'on/off':
					case 'on-off':
						$string = $bool ? 'on' : 'off';
						break;
	
					case 'tf':
					case 't/f':
					case 't-f':
					case 'truefalse':
					case 'true/false':
					case 'true-false':
						$string = $bool ? 'true' : 'false';
						break;
	
					case 'yn':
					case 'y/n':
					case 'y-n':
					case 'yesno':
					case 'yes/no':
					case 'yes-no':
						$string = $bool ? 'yes' : 'no';
						break;
	
					default:
						throw new \InvalidArgumentException(
							__FUNCTION__."() expects parameter two, format, to be one of the following: ".
								"'t[/-]f', 'true[/-]false', 'y[/-]s', 'yes[/-]no', 'o[/-]o', or ".
								"'on[/-]off', '$format' given"
						);
				}
			}
		}
	}
	return $string;
}

/**
 * Returns the boolean value of $var
 *
 * PHP's native boolval() function is not available before PHP 5.5, and it does not
 * support the strings 'yes', 'no', 'on', or 'off'.
 *
 * I follow the following rules:
 * 
 *     Strings
 *         The strings "yes", "true", "on", or "1" are considered true, and
 *         the strings "no", "false", "off", or "0" are considered false 
 *         (case-insensitive). Any other non-empty string is true. 
 *
 *     Numbers
 *         The numbers 0 or 0.0 are considered false. Any other number is 
 *         considered true.
 *
 *     Array
 *         An empty array is considered false. Any other array (even an
 *         associative array with no values) is considered true.
 *
 *     Object
 *         Any object is considered true.
 *
 * For example...
 *
 *     Bool::val("");              // returns (bool) false
 *     Bool::val(true);            // returns (bool) true
 *     Bool::val(0);               // returns (bool) false
 *     Bool::val(0.0);             // returns (bool) false
 *     Bool::val('0');             // returns (bool) false
 *     Bool::val('abc');           // returns (bool) true
 *     Bool::val('true');          // returns (bool) true
 *     Bool::val('on');            // returns (bool) true
 *     Bool::val('yes');           // returns (bool) true
 *     Bool::val('off');           // returns (bool) false
 *     Bool::val([]);              // returns (bool) false
 *     Bool::val([1, 2]);          // returns (bool) true
 *     Bool::val(new StdClass());  // returns (bool) true
 * 
 * @since  0.1.0
 *
 * @param  mixed  $var  the variable to test
 *
 * @return  bool  the bool value
 *
 * @see  http://www.php.net/manual/en/function.boolval.php  boolval() man page
 */
function valtobool($val){
	$value = null;
	if ( ! empty($val)) {
		if ( ! is_bool($val)) {
			if (is_string($val)) {
				switch (strtolower($val)) {
					case '1':
					case 'on':
					case 'yes':
					case 'true':
						$value = true;
						break;
					case '0':
					case 'no':
					case 'off':
					case 'false':
						$value = false;
						break;
					default:
						$value = ! empty($val);
				}
			} elseif (is_numeric($val)) {
				$value = ($val !== 0 && $val !== 0.0);
			} elseif (is_object($val)) {
				$value = true;
			} elseif (is_array($val)) {
				$value = ! empty($val);
			}
		} else {
			$value = $val;
		}
	} else {
		$value = false;
	}
	return $value;
}