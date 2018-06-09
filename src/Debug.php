<?php

namespace richardevcom\PHPHelpers;

/**
 * Print var_dump() or print_r()
 * @param mixed $data Data to dump
 * @param bool $print_r User print_r()?
 */
function dump($data, $print_r = false){
	echo '<pre>';
	if(!$print_r){
		var_dump($data);
	}else{
		print_r($data);
	}
	echo '</pre>';
}

/**
 * Report / Print errors
 * @param bool $errors
 * @param bool $startup
 * @param const $level
 */
function report_errors($errors = 1, $startup = 1, $level = E_ALL){
	ini_set('display_errors', $errors);
	ini_set('display_startup_errors', $startup);
	error_reporting($level);
}

/**
 * Log errors
 * @param bool $log
 * @param string $file
 */
function log_errors($log = 1, $file = 'php-error.log'){
	ini_set("log_errors", $log);
	ini_set("error_log", $file);
}

/**
 * Log string in Browser console (JS)
 * @param string $string
 */
function console_log($string) {
    echo "<script>\n";
    echo "//<![CDATA[\n";
    echo "console.log(", json_encode($string), ");\n";
    echo "//]]>\n";
    echo "</script>";
}