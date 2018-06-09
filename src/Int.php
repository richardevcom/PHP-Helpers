<?php

namespace richardevcom\PHPHelpers;

/**
 * Return ordinal format of number
 * @param int $int Number to format
 * @return string
 */
function ordinal($int) {
    $suffix = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($int % 100) >= 11) && (($int%100) <= 13))
        return $int. 'th';
    else
        return $int. $suffix[$int % 10];
}

/**
 * Returns the numeric value of $var
 * For example:
 *
 *     Num::bool(true);           // returns (int) 1
 *     Num::val(1);               // returns (int) 1
 *     Num::val('1');             // returns (int) 1
 *     Num::val(1.5);             // returns (float) 1.5
 *     Num::val('1.5');           // returns (float) 1.5
 *     Num::val('1 1/2');         // returns (float) 1.5
 *     Num::val('3/2');           // returns (float) 1.5
 *     Num::val('3\2');           // returns (float) 1.5
 *     Num::val('1000');          // returns (int) 1000
 *     Num::val('1,000');         // returns (int) 1000
 *     Num::val('1,000.5');       // returns (float) 1000.5
 *     Num::val('10000');         // returns (int) 10000
 *     Num::val('1st);            // returns (int) 1
 *     Num::val('second');        // returns (int) 2
 *     Num::val('one hundred');   // returns (int) 100
 *     Num::val('1,0,0');         // returns 0
 *     Num::val('abc');           // returns 0
 *     Num::val(array());         // returns 0
 *     Num::val(array('foo'));    // returns 1
 *     Num::val(new stdClass());  // returns 1
 *
 * @param  mixed  $var  the value to evaluate
 * @return  int|float  the value's numeric equivalent
 */
function to_int($var) {
	$value = false;
	
	// if $var is a string, trim it
	if (is_string($var)) {
		$var = trim($var);	
	}
	// if the string is not already a (float), (integer), or numeric (string)
	if ( ! is_numeric($var)) {
		// if the number is a string
		if (is_string($var)) {
			// if the number is a number with commas (e.g., "1,000")
			// else, if the number is a fraction or mixed number (e.g., "1/2")
			// else, if the number has a suffix (e.g., "1st")
			// else, if the number is the name for a number  (e.g., "one hundred")
			// otherwise, it's zero
			//
			if (preg_match('#^([1-9](?:\d*|(?:\d{0,2})(?:,\d{3})*)(?:\.\d*[0-9])?|0?\.\d*[0-9]|0)$#', $var)) {
				$value = +str_replace(',', '', $var);
			} elseif (preg_match('#^((\d+)\s+)?(\d+)[/\\\](\d+)$#', $var, $m)) {
				$value = $m[2] + $m[3] / $m[4];
			} elseif (is_numeric(substr($var, 0, 1)) && in_array(substr($var, -2), array('th', 'st', 'nd', 'rd'))) {
				$value = substr($var, 0, -2);
			} else {
				// if the string is composed *only* of valid number names
				//
				// first, lowercase $var, strip commas, and replace "-" and " and " with spaces
				// then, explode on space, trim, and filter out empty values 
				// finally, merge all the possible numeric string values together
				//
				$words = strtolower($var);
				$words = str_ireplace(',', '', $words);
				$words = str_ireplace(array('-', ' and '), ' ', $words);
				$words = array_filter(array_map('trim', explode(' ', $words)));

				$cardinals = array(
					'one'       => 1, 
					'two'       => 2,
					'three'     => 3,
					'four'      => 4,
					'five'      => 5,
					'six'       => 6,
					'seven'     => 7,
					'eight'     => 8,
					'nine'      => 9,
					'ten'       => 10,
					'eleven'    => 11,
					'twelve'    => 12,
					'thirteen'  => 13,
					'fourteen'  => 14,
					'fifteen'   => 15,
					'sixteen'   => 16,
					'seventeen' => 17,
					'eighteen'  => 18,
					'nineteen'  => 19,
					'twenty'    => 20,
					'thirty'    => 30,
					'forty'     => 40,
					'fifty'     => 50,
					'sixty'     => 60,
					'seventy'   => 70,
					'eighty'    => 80,
					'ninety'    => 90
				);
				$ordinals = array(
					'first'       => 1,
					'second'      => 2,
					'third'       => 3,
					'fourth'      => 4,
					'fifth'       => 5,
					'sixth'       => 6,
					'seventh'     => 7,
					'eighth'      => 8,
					'nineth'      => 9,
					'tenth'       => 10,
					'eleventh'    => 11,
					'twelveth'    => 12,
					'thirteenth'  => 13,
					'fourteenth'  => 14,
					'fifteenth'   => 15,
					'sixteenth'   => 16,
					'seventeenth' => 17,
					'eighteenth'  => 18,
					'nineteenth'  => 19,
					'twentieth'   => 20,
					'thirtieth'   => 30,
					'fourtieth'   => 40,
					'fiftieth'    => 50,
					'sixtieth'    => 60,
					'seventieth'  => 70,
					'eightieth'   => 80,
					'ninetieth'   => 90
				);
				$powers = array(
					'hundred'  => 100,
					'thousand' => 1000,
					'million'  => 1000000,
					'billion'  => 1000000000
				);
				$names = array_merge(
					array_keys($cardinals),
					array_keys($ordinals),
					array_keys($powers)
				);
				if (count(array_diff($words, $names)) === 0) {
					// replace the words with their numeric values
					$var = strtr(
						strtolower($var),
						array_merge($cardinals, $ordinals, $powers,
							array('and' => '')
						)
					);
					// convert the numeric values to integers
				    $parts = array_map(
				        function ($val) {
				            return intval($val);
				        },
				        preg_split('/[\s-]+/', $var)
				    );
				
				    $stack = new \SplStack();  // the current work stack
				    $sum   = 0;               // the running total
				    $last  = null;            // the last part
				
					// loop through the parts
				    foreach ($parts as $part) {
				    	// if the stack isn't empty
				        if ( ! $stack->isEmpty()) {
				            // we're part way through a phrase
				            if ($stack->top() > $part) {
				                // decreasing step, e.g. from hundreds to ones
				                if ($last >= 1000) {
				                    // If we drop from more than 1000 then we've finished the phrase
				                    $sum += $stack->pop();
				                    // This is the first element of a new phrase
				                    $stack->push($part);
				                } else {
				                    // Drop down from less than 1000, just addition
				                    // e.g. "seventy one" -> "70 1" -> "70 + 1"
				                    $stack->push($stack->pop() + $part);
				                }
				            } else {
				                // Increasing step, e.g ones to hundreds
				                $stack->push($stack->pop() * $part);
				            }
				        } else {
				            // This is the first element of a new phrase
				            $stack->push($part);
				        }
				
				        // Store the last processed part
				        $last = $part;
				    }
				
				    $value = $sum + $stack->pop();
				} else {
					$value = 0;	
				}
			}
		} elseif (is_array($var)) {
			$value = min(count($var), 1);
		} elseif (is_object($var)) {
			$value = 1;
		} elseif (is_bool($var)) {
			$value = (int) $var;
		}
	} else {
		$value = +$var;
	}
	return $value;
}