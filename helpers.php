<?php

/** Return file dirname path */
function file_dirname(){
	return dirname(__FILE__);
}

/** Return MySQL timestamp formated date/time */
function mysql_timestamp($time = false){
	$time ? false : $time = time();
	return date("Y-m-d H:i:s", $time);
}


/** Return system base URL */
function get_base_url(){
	return sprintf(
		"%s://%s%s",
		is_secure() ? 'https' : 'http',
		$_SERVER['SERVER_NAME'],
		$_SERVER['REQUEST_URI']
	);
}

/** Check if using HTTPS protocol */
function is_secure() {
  return (!empty($_SERVER['HTTPS']) && filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN));
}

/**
 * Call one or more functions with one or more arguments
 */
function call_functions($func){
	// Check if is array
	if(is_array($func)){
		// Check if is multidimensional
		if(is_multi_array($func)){
			foreach($func as $subfunc){
				if(is_array($subfunc)){
					// Strip the function name to leave only arguments
					$subname = $subfunc[0];
					unset($subfunc[0]);
					$args = $subfunc;

					call_user_func_array($subname,$args);
				}else{
					call_user_func($subname);
				}

			}
			return;
		}

		$name = $func[0];
		unset($func[0]);
		$args = $func;

		call_user_func_array($name,$args);
	}else{
		call_user_func($func);
	}
}

/**
 * Check if array is multidimensional
 */
function is_multi_array($arr) {
    $filter = array_filter($arr,'is_array');
    if(count($filter)>0) return true;
    return false;
}

/**
 * Check if value exists in multidimensional array
 */
function in_multi_array($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_multi_array($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}

/**
 * Check if file exists & add it
 */
function include_file($file, $die = false, $method = 'require_once'){
	if(file_exists($file)){
		switch ($method) {
			case 'include':
				include($file);
				break;
			case 'include_once':
				include_once($file);
				break;
			case 'require':
				require($file);
				break;
			default:
				require_once($file);
				break;
		}
		return true;
	}
	if($die === true) die();
	return false;
}

/**
 * Search for value in multi array
 */
function multi_array_search($needle, $haystack, $method='array'){
	$array = array();
	foreach($haystack as $key=>$val){
		if(is_array($val)){
			$find = array_search($needle, $val);
			if($find){
				$array[$key] = $val;
			}
		}else{
			if($needle == $key || $needle == $val) $array[$key] = $val;
		}

	}

	if(empty($array)) return false;
	
	// Return TRUE or FALSE
	if($method == 'bool') return true;
	// Return key values
	if($method == 'key'){
		$akey = array();
		foreach ($array as $key => $value) {
			$akey[] = $key;
		}
		return $akey;
	}
	// Return array
	if($method == 'array') return $array;

	return false;
}

/* Check if file exists in provided url */
function file_url_exists($url){
	$ch = curl_init($url);    
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if($code == 200){
	   $status = true;
	}else{
	  $status = false;
	}
	curl_close($ch);
	return $status;
}

/* Import JSON file & decode it */
function import_json($file){
	if(preg_match("~^(?:f|ht)tps?://~i", $file)){
		if(file_url_exists($file)){
			$content = file_get_contents($file, true);

			$json = json_decode($content, true);
			return $json;
		}
	}else{
		if(file_exists($file)){
			$content = file_get_contents($file, true);

			$json = json_decode($content, true);
			return $json;
		}
	}
	
	return false;
}

/* Export JSON file & decode it */
function export_json($file, $data){
	if(!preg_match("~^(?:f|ht)tps?://~i", $file)){
		$json = json_encode($data);
		$content = file_put_contents($file, $data);
		return true;
	}

	return false;
}

/* Create file with or without data */
function create_file($file, $data = '', $force = false){
	if(file_exists($file) && $force == false){
		return false;
	}else{
		$file = fopen($file,"wb");
		fwrite($file,$data);
		fclose($file);
		return true;
	}
}

function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

// Check if directory is empty
function is_dir_empty($dir) {
  if (!is_readable($dir)) return NULL; 
  return (count(scandir($dir)) == 2);
}
