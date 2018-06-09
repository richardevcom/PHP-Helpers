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