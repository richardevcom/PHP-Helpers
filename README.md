[![GitHub license](https://img.shields.io/github/license/richardevcom/PHP-Helpers.svg)](https://github.com/richardevcom/PHP-Helpers/blob/master/LICENSE)
[![GitHub release](https://img.shields.io/github/release/richardevcom/PHP-Helpers.svg)](https://github.com/richardevcom/PHP-Helpers/releases/)

# PHP Helper functions
[![Generic badge](https://img.shields.io/badge/DOWNLOAD-HERE-brightgreen.svg)](https://github.com/richardevcom/PHP-Helpers/archive/master.zip)

## Table of Contents
- **[Installation](#install-with-composer)**
- **[Array](#array)**
- **[Notice](#notice)**

## Install with Composer
```
composer require richardevcom/php-helpers
```
## Manual install
Just include file which functions set you want to use.
```php
// Array helper functions file
require_once('src/Array.php');
// File helper functions file
require_once('src/File.php');
// etc...
```

## Array
**Check if array is multidimensional**
`is_multi_array($array)`
```php
$array  = array("Volvo", "BMW", "Saab");
$multi_array  = array(
  array("Volvo",22,18),
  array("BMW",15,13),
  array("Saab",5,2)
);

echo is_multi_array(array $arr);        // FALSE
echo is_multi_array($multi_array);  // TRUE
```

**Check if value exists in multidimensional array**
`in_multi_array($needle, array $haystack, $strict = false)`
```php
$array  = array(
  array("Audi",22,18),
  array("BMW",15,13),
  array("Ford",5,2)
);

echo in_multi_array('audi', $array);  // FALSE
echo in_multi_array('bmw', $array);   // TRUE

// Strict mode
echo in_multi_array('bmw', $array, true);  // FALSE
echo in_multi_array('BMW', $array, true);  // TRUE
```

**Check if array is associative**
`is_assoc_array($arr)`
```php
$numeric  = array("one", "two", "three");
$assoc    = array(
  "one"   => 1,
  "two"   => 2,
  "three" => 3,
);

echo is_assoc_array($numeric);  // FALSE
echo is_assoc_array($assoc);    // TRUE
```

**Check if array is a numeric**
`is_numeric_array($arr)`
```php
$numeric  = array("one", "two", "three");
$assoc    = array(
  "one"   => 1,
  "two"   => 2,
  "three" => 3,
);

echo is_assoc_array($numeric);  // TRUE
echo is_assoc_array($assoc);    // FALSE
```

**Search values in multidimensional array**
`multi_array_search($needles, array $haystack)`
```php
$string_needle  = "Audi";
$array_needles  = array("Audi", 15, "Ford");

$array  = array(
  array("Audi",22,18),
  array("BMW",15,13),
  array(1,5,"Ford")
);

var_dump(multi_array_search($string_needle, $array));
/**
 * array(1) {
 *    [0]=> array(1) {
 *      [0]=> int(0)
 *    }
 * }
 */
 
var_dump(multi_array_search($array_needles, $array));
/**
 * array(3) {
 *    [0]=> array(1) {
 *      [0]=> int(0)
 *    }
 *    [1]=> array(1) {
 *      [0]=> int(1)
 *    }
 *    [2]=> array(1) {
 *      [0]=> int(2)
 *    }
 * }
 */
```

**Get random array value**
`random_array($arr)`
```php
$array  = array("one", "two", "three");
echo random_array($array);  // two, two, one, three, one, etc.
```

**Check if array is empty**
`is_array_empty($array, $key = null, $zero = true)`
```php
$first  = array();
$second = array(0, "0", "0.00");
$third  = array("one", "two", "three");

echo is_array_empty($first);  // TRUE
echo is_array_empty($second);  // FALSE
echo is_array_empty($third);  // FALSE

// Without zeros
echo is_array_empty($second, false);  // TRUE

// Specific key
$multi  = array(
	"one"	=> array(),
	"two"	=> array(1, 2, 3)
);

echo is_array_empty($multi, true, "one"); // TRUE
```

**Flatten a multi-dimensional array into a one dimensional array**
`flatten(array $array, $preserveKeys = true)`
```php
$array  = array(
	"first"		=> array("one", "two", "three"),
	"second"	=> array(1, 2, 3)
);

var_dump(flatten($array));
/**
 * array(6) {
 *    [0]=> string(3) "one"
 *    [1]=> string(3) "two"
 *    [2]=> string(5) "three"
 *    [3]=> int(1)
 *    [4]=> int(2)
 *    [5]=> int(3)
 * }
 */
```

## Notice
To avoid function name conflict use <code>richardevcom\PHPHelpers</code> namespace!
