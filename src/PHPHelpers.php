<?php

namespace richardevcom\PHPHelpers;

// Current file directory
define('__FILEDIR__', dirname(__FILE__));
// Current file parent directory
define('__PARENTDIR__', dirname(__FILEDIR__));
// Current file extension
define('__EXTENSION__', pathinfo(__FILE__, PATHINFO_EXTENSION));
// Current file name (without extension)
define('__NAME__', pathinfo(__FILE__, PATHINFO_FILENAME));
// Current file name (with extension / full)
define('__FILENAME__', __NAME__ . '.' . __EXTENSION__);
// Current file directory name
define('__DIRNAME__', basename(__DIR__) );

/**
 * Human readable var_dump()
 * @param mixed $data Data to dump
 * @param bool $die Exit PHP after dump?
 */
function dump($data, $die = false){
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
	if($die) die();
}

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
 * Remove $_GET variables from url 
 * @param string $url URL path to filter
 * @param string|array $vars The $_GET variables to be removed. Removes all by default.
 * @return string Returns filtered string
 */
function remove_get_vars($url, $vars = '') {
	$parts = parse_url($url);
	$params = array();
	parse_str($parts['query'], $params);
	if($vars){
		if(is_array($vars)){
			foreach ($vars as $var) {
				unset($params[$var]);
			}
		}else{
			unset($params[$vars]);
		}
	}else{
		$params = array();
	}

	$query = http_build_query($params);

	$get_string = '';
	if($query) $get_string = '?' . $query;

	return $parts['scheme'] . '://' . $parts['host'] . $parts['path'] . $get_string;
}

/** 
 * Remove file extension from url
 * @param string $url URL path to filter
 * @param string $ext File extension to remove. Removes any by default.
 * @return string Returns filtered URL
 **/
function remove_url_ext($url, $ext = ''){
	$path = pathinfo(remove_get_vars($url));
	if($path['extension'] == $ext) return str_replace($path['filename'] . '.' . $path['extension'], '', $url);
	return str_replace($path['filename'] . '.' . $path['extension'], '', $url);;
}

/** 
 * Return current page URL
 * @param bool $ext Keep filename & extension in URL
 * @param bool $vars Keep $_GET variables in URL
 * @return string Returns filtered URL
 */
function page_url($ext = true, $vars = true){
	$url = sprintf(
		"%s://%s%s",
		is_path_secure() ? 'https' : 'http',
		$_SERVER['SERVER_NAME'],
		$_SERVER['REQUEST_URI']
	);

	if(!$ext) $url = remove_url_ext($url);
	if(!$vars) $url = remove_get_vars($url);

	return $url;
}

/**
 * Remove slash from end of path
 * @param string $path The path to filter
 * @return string Returns filtered path
 */
function rtrim_slash($path){
	return rtrim($path,"/");
}

/**
 * Remove backslash from end of path
 * @param string $path The path to filter
 * @return string Returns filtered path
 */
function rtrim_backslash($path){
	return rtrim($path, "\\");
}

/** 
 * Return base url
 * @return string Returns base URL
 **/
function base_url() {
    $path = pathinfo($_SERVER['PHP_SELF']); 
    $http = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5)) =='https://'?'https://':'http://';
    return $http.$_SERVER['HTTP_HOST'].$path['dirname']."/";
}

/** 
 * Check if using HTTPS protocol
 * @param string $path The path to check
 * @return bool
 */
function is_secure($path = '') {
	if($path && !empty($path)) return (strpos($path, "https://") !== false);
  	return (!empty($_SERVER['HTTPS']) && filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN));
}


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
 * Check if file exists & add it
 * @param string $file File path to include
 * @param bool $req Require file? Default true
 * @param bool $once Require || Include once?
 * @return bool
 */
function insert($file, $req = 1, $once = 1){
	if(file_exists($file)){
		if(!$req){
			if($once) return include_once($file);
			return include($file);
		}
		if($once) return require_once($file);
		return require($file);
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
 * Check if file exists in provided url
 * @param string $url File URL to check
 * @return bool
 */
function file_url_exists($url){
	if(function_exists('curl_version')){
		$ch = curl_init($url);    
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if($code == 200){
		   return true;
		}else{
		  $status = false;
		}
		curl_close($ch);
		return $status;
	}
	trigger_error("Please enable <strong>CURL</strong> for use in <strong>file_url_exists</strong> function.", E_USER_ERROR);
}

/**
 * Get file contents using URL path
 * @param string $url URL of file to get
 * @param string $agent Browser agent to use
 * @return string
 */
function curl_get_contents($url, $agent = 'Mozilla/5.0 (Windows NT 6.1; rv:19.0) Gecko/20100101 Firefox/19.0') {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    if($agent) curl_setopt($ch, CURLOPT_USERAGENT, $agent);       

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

/**
 * Import JSON file & decode it
 * @param string $file Path to JSON file for import
 * @param bool $decode Decode JSON content?
 * @param int $opts JSON decode options
 * @param int $depth Recursion depth
 * @return mixed
 */
function import_json($file, $decode = true, $opts = 0, $depth = 512){
	if(file_exists($file) || file_url_exists($file)){
		try{
		    $result = json_decode(file_get_contents($file), $decode, $depth, $opts);
		}catch(Exception $e){
		    $result = json_decode(curl_get_contents($file), $decode, $depth, $opts);
		}
		return $result;
	}
	return false;
}

/**
 * Export JSON file & decode it
 * @param array $data Array to convert
 * @param string $file File path to create
 * @param int $opts JSON encode options
 * @return mixed
 */
function export_json($data, $file = null, $opts = 0){
	if(!preg_match("~^(?:f|ht)tps?://~i", $file)){
		$json = json_encode($data, $opts);
		if($file && !empty($file)){
			return file_put_contents($file, $json);
		}else{
			return $json;
		}
	}

	return false;
}

/**
 * Create file with or without data
 * @param string $file File path to create
 * @param mixed $data Data to store in file
 * @param bool $force Force overwriting if file exists?
 * @return bool
 */
function create_file($file, $data = '', $force = false){
	if(file_exists($file) && $force == false){
		return false;
	}else{
		$file = fopen($file,"wb");
		fwrite($file,$data);
		fclose($file);
	}
	return file_exists($file);
}

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
 * Check if directory is empty
 * @param string $dir Directory path to check
 * @return bool
 */
function is_dir_empty($dir) {
  if (!is_readable($dir)) return NULL; 
  return (count(scandir($dir)) == 2);
}

/**
 * Check if file is empty
 * @param string $file File to check
 * @param bool $ignore Ignore whitespaces, tabs, new lines?
 * @return bool
 */
function is_file_empty($file, $ignore = false){
	$file = file_get_contents($file);
	if($ignore) $file = preg_replace('/\s+/S', "", $file);
	return (strlen($file) == 0);
}

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

/**
 * Get random array value
 * @param array $arr Array to shuffle and pop
 * @return string
 */
function random_array($arr){
    return $arr[array_rand($arr)];
}

/**
 * Check if string starts with "*" character
 * @param string $search Characters to search for
 * @param string $string String to check
 * @param bool $sensitive Use case sensitive search?
 * @return string
 */
function str_starts($search, $string, $sensitive = true){
	if(!$sensitive){
		$string = strtolower($string);
		$search = strtolower($search);
	}

	return (substr($string, 0, strlen($string)) === $search);
}

/**
 * Check if string ends with "*" character
 * @param string $search Characters to search for
 * @param string $string String to check
 * @param bool $sensitive Use case sensitive search?
 * @return string
 */
function str_ends($search, $string, $sensitive = true){
	if(!$sensitive){
		$string = strtolower($string);
		$search = strtolower($search);
	}

	$length = strlen($search);

    return $length === 0 || (substr($string, -$length) === $search);
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
 * @param bool $sensitive Use case sensitive search?
 * @return string
 */
function str_before($search, $string, $sensitive = true) {
	if(!$sensitive){
		$string = strtolower($string);
		$search = strtolower($search);
	}
	$result =	substr($string, 0, strpos($string, $search));

	if($result) return $result;
	return $string;
}

/**
 * Extract string after characters
 * @param string $search Characters after to cut
 * @param string $string String to check
 * @param bool $sensitive Use case sensitive search?
 * @return string
 */
function str_after($search, $string, $sensitive = true){
	if(!$sensitive){
		$string = strtolower($string);
		$search = strtolower($search);
	}
	$result = substr($string, strpos($string, $search) + strlen($search));

	if($result) return $result;
	return $string;
}

/**
 * Add string before characters found
 * @param string $search Characters to filter
 * @param string $replace Replacement string
 * @param string $string String to filter
 * @param bool $sensitive Use case sensitive search?
 * @return string
 */
function str_add_before($search, $replace, $string, $sensitive = true){
	if($sensitive) return str_replace($search, $replace.$search, $string);
	return str_ireplace($search, $replace.$search, $string);
}

/**
 * Add string after characters found
 * @param string $search Characters to filter
 * @param string $replace Replacement string
 * @param string $string String to filter
 * @param bool $sensitive Use case sensitive search?
 * @return string
 */
function str_add_after($search, $replace, $string, $sensitive = true){
	if($sensitive) return str_replace($search, $search.$replace, $string);
	return str_ireplace($search, $search.$replace, $string);
}