<?php

namespace richardevcom\PHPHelpers;

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
 * Get file contents (can use offset & data length)
 * @param string $file File path to create
 * @param int $offset Point from where to read data
 * @param int $length Length of data to return
 * @return bool
 */
function get_contents($file, $offset = 0, $length = 0 ){
    if(!$length){
    	$result = file_get_contents($file, false, null, $offset);
	}else{
		$result = file_get_contents($file, false, null, $offset, $length);
	}
	if ($result === false) {
	    throw new \RuntimeException("Cannot read the file: " . $file);
	}
	return $result;
}

/**
 * Create file with or without data
 * @param string $file File path to create
 * @param mixed $data Data to store in file
 * @param bool $append Add to the end of file?
 * @return bool
 */
function put_contents($file, $data = '', $append = false){
	if(!$append){
		$result = file_put_contents($file, $data, \LOCK_EX | \LOCK_NB);
	}else{
		$result = file_put_contents($file, $data, \LOCK_EX | \LOCK_NB | \FILE_APPEND);
	}
	
    if ($result === false) {
        throw new \RuntimeException("Cannot write the file: " . $file);
    }
}