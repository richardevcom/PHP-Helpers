<?php

namespace richardevcom\PHPHelpers;

/**
 * Check if array is multidimensional
 * @param array $arr Array to check
 * @return bool
 */
function is_multi_array(array $arr) {
    $filter = array_filter($arr,'is_array');
    if(count($filter)>0) return true;
    return false;
}

/**
 * Check if value exists in multidimensional array
 * @param string $needle String to search for in array
 * @param array $haystack Multidimensional array to search in
 * @param bool $strict Strict check - uses === to compare variable types
 */
function in_multi_array($needle, array $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_multi_array($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}
/**
 * Check if array is associative
 * @param array $arr The array to check
 * @return bool
 */
function is_assoc_array($arr){
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}

/**
 * Check if variable is a numeric array.
 * 
 * @param array $arr
 * @return boolean
 */
function is_numeric_array($arr){
    if (array() === $arr) return false;
    
    $keys = array_keys($arr);
    return ($keys === array_keys($keys));
}

/**
 * Search values in multidimensional array
 * @param string|array $needles String or array of values to search for
 * @param array $haystack The array to search in
 * @return array Returns array list of keys
 */
function multi_array_search($needles, array $haystack){
	$result = array();

	if(!is_array($needles)) $needles = array($needles);

	foreach ($needles as $needle) {
		if(is_array($haystack)){
			foreach ($haystack as $key => $array) {
				if(is_array($array)){
					if(is_multi_array($array)){
						$prep = multi_array_search($needles, $array);
						if($prep) $result[$key] = $prep;
					}else{
						$prep	= array_search($needle, $array);
						if($prep) $result[$key][] = $prep;
					}
				}
			}
		}
	}
	return $result;
}

/**
 * Get random array value
 * @param array $arr Array to shuffle and pop
 * @return string
 */
function random_array($arr){
    return $arr[array_rand($arr)];
}

/**
 * Check if array is empty
 * @param array $array
 * @param mixed $key
 * @param bool $zero
 * @return bool
 */
function is_array_empty($array, $key = null, $zero = true) {
	$empty = true;

	if ($key !== null && $array !== null) {
		if (is_string($key)) {
			if (is_array($array)) {
				if (is_bool($zero)) {
					if ( ! empty($array)) {
						if (array_key_exists($key, $array)) {
							$empty = empty($array[$key]);
							if ($empty && ! $zero) {
								$empty = $number === 0 
										|| $number === 0.0 
										|| $number === '0' 
										|| $number === '0.0';
							}
						}
					}
				}
			}
		}
	}

	return $empty;
}

/**
 * Flatten a multi-dimensional array into a one dimensional array.
 *
 * @param  array   $array         The array to flatten
 * @param  boolean $preserveKeys  Whether or not to preserve array keys. Keys from deeply nested arrays will
 *                                overwrite keys from shallow nested arrays
 * @return array
 */
function flatten(array $array, $preserveKeys = true): array{
    $flattened = [];
    array_walk_recursive($array, function ($value, $key) use (&$flattened, $preserveKeys) {
        if ($preserveKeys && !is_int($key)) {
            $flattened[$key] = $value;
        } else {
            $flattened[] = $value;
        }
    });
    return $flattened;
}

/**
 * Searches for a given value in an array of arrays, objects and scalar values. You can optionally specify
 * a field of the nested arrays and objects to search in.
 *
 * @param  array $array  The array to search
 * @param  mixed $search The value to search for
 * @param  bool  $field  The field to search in, if not specified all fields will be searched
 * @return boolean|mixed  False on failure or the array key on success
 */
function search(array $array, $search, $field = false) {
    // *grumbles* stupid PHP type system
    $search = (string)$search;
    foreach ($array as $key => $elem) {
        // *grumbles* stupid PHP type system
        $key = (string)$key;
        if ($field) {
            if (is_object($elem) && $elem->{$field} === $search) {
                return $key;
            }
            if (is_array($elem) && $elem[$field] === $search) {
                return $key;
            }
            if (is_scalar($elem) && $elem === $search) {
                return $key;
            }
        } else {
            if (is_object($elem)) {
                $elem = (array)$elem;
                /** @noinspection NotOptimalIfConditionsInspection */
                if (in_array($search, $elem, false)) {
                    return $key;
                }
            } elseif (is_array($elem) && in_array($search, $elem, false)) {
                return $key;
            } elseif (is_scalar($elem) && $elem === $search) {
                return $key;
            }
        }
    }
    return false;
}
