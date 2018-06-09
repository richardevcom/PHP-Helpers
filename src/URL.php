<?php

namespace richardevcom\PHPHelpers;

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