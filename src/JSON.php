<?php

namespace richardevcom\PHPHelpers;

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