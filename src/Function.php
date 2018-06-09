<?php

namespace richardevcom\PHPHelpers;

/**
 * Call one or more functions with one or more arguments
 * @param string|array $func Single or array list of functions & arguments to call
 */
function call_func($func){
	if(!is_array($func)){
		call_user_func($func);
	}else{
		foreach ($func as $key => $args) {
			if(!is_array($args)){
				if(!$args){
					call_user_func($key);
				}else{
					call_user_func($key, $args);
				}
			}else{
				call_user_func_array($key, $args);
			}
		}
	}
}

/**
 * Call function only once using call_user_func()
 * @param string $name Function name
 * @param 
 */
function call_func_once($func){
	static $call_func_once = array();
	
	if(!is_array($func)){
		if(!isset($call_func_once[$func])){
			$call_func_once[$func] = true;
			call_func($func);
		}
	}else{
		foreach ($func as $key => $value) {
			if(!isset($call_func_once[$key])){
				$call_func_once[$key] = true;
				call_func($func);
			}
		}
	}
}