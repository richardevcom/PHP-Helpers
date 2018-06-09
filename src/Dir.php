<?php

namespace richardevcom\PHPHelpers;

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
 * Returns a relative path (aka, "rel") from an absolute path (aka, "abs")
 * @param   string  $from  the abosolute path (e.g., 'C:\path\to\folder')
 * @param   string  $to      the relative base (e.g., 'C:\path\to')
 * @return  string  the relative path (e.g., 'folder') or false on failure
 */
function abs2rel($from, $to) {
    // some compatibility fixes for Windows paths
    $from = is_dir($from) ? rtrim($from, '\/') . '/' : $from;
    $to   = is_dir($to)   ? rtrim($to, '\/') . '/'   : $to;
    $from = str_replace('\\', '/', $from);
    $to   = str_replace('\\', '/', $to);

    $from     = explode('/', $from);
    $to       = explode('/', $to);
    $relPath  = $to;

    foreach($from as $depth => $dir) {
        // find first non-matching dir
        if($dir === $to[$depth]) {
            // ignore this directory
            array_shift($relPath);
        } else {
            // get number of remaining dirs to $from
            $remaining = count($from) - $depth;
            if($remaining > 1) {
                // add traversals up to first matching dir
                $padLength = (count($relPath) + $remaining - 1) * -1;
                $relPath = array_pad($relPath, $padLength, '..');
                break;
            } else {
                $relPath[0] = './' . $relPath[0];
            }
        }
    }
    return implode('/', $relPath);
}

/**
 * Copies files or directory to the filesystem
 * @param  string  $source       the source directory path
 * @param  string  $destination  the destination directory path
 */
function cp($src, $dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 

/**
 * Deletes a directory and its sub-directories & files
 * @param  string  $directory  the path of the directory to remove
 */
function rm($directory){
	$dir = $directory;
	$it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
	$files = new \RecursiveIteratorIterator($it,
	             \RecursiveIteratorIterator::CHILD_FIRST);
	foreach($files as $file) {
	    if ($file->isDir()){
	        rmdir($file->getRealPath());
	    } else {
	        unlink($file->getRealPath());
	    }
	}
	rmdir($dir);
}