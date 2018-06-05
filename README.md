[![GitHub license](https://img.shields.io/github/license/richardevcom/PHP-Helpers.svg)](https://github.com/richardevcom/PHP-Helpers/blob/master/LICENSE)
[![GitHub release](https://img.shields.io/github/release/richardevcom/PHP-Helpers.svg)](https://github.com/richardevcom/PHP-Helpers/releases/)

# PHP Helper functions
[![Generic badge](https://img.shields.io/badge/DOWNLOAD-HERE-brightgreen.svg)](https://github.com/richardevcom/PHP-Helpers/archive/master.zip)

## Install with Composer
```
composer require richardevcom/php-helper
```
## Manual install
```php
require_once('helpers.php');
```
## Description

### Constants
<code>&#95;&#95;FILEDIR&#95;&#95;</code>          - Current file directory<br/>
<code>&#95;&#95;PARENTDIR&#95;&#95;</code>        - Current file parent directory<br/>
<code>&#95;&#95;EXTENSION&#95;&#95;</code>        - Current file extension<br/>
<code>&#95;&#95;NAME&#95;&#95;</code>             - Current file name (without extension)<br/>
<code>&#95;&#95;FILENAME&#95;&#95;</code>              - Current file name (with extension)<br/>
<code>&#95;&#95;DIRNAME&#95;&#95;</code>               - Current file directory name<br/>
```php
echo __FILEDIR__;
// Prints: /home/user/project
echo __PARENTDIR__;
// Prints: /home/user
echo __EXTENSION__;
// Prints: php
echo __NAME__;
// Prints: helpers
echo __FILENAME__;
// Prints: helpers.php
echo __DIRNAME__;
// Prints: project
```

### Arrays
<code>in_multi_array</code>      - Check if value exists in multidimensional array<br/>
<code>is_multi_array</code>      - Check if array is multidimensional<br/>
<code>multi_array_search</code>  - Search for value in multi array<br/>

### Files & Directories
<code>create_file</code>         - Create file with or without data<br/>
<code>file_dirname</code>        - Return file dirname path<br/>
<code>include_file</code>        - Check if file exists & add it<br/>
<code>is_dir_empty</code>        - Check if directory has files<br/>

### Functions
<code>call_func_once</code>      - Call function only once (using <code>call_user_func()</code>)<br/>
<code>call_functions</code>      - Call one or more functions with one or more arguments (for multi-array call)<br/>

### JSON
<code>export_json</code>         - Export JSON file & decode it<br/>
<code>import_json</code>         - Import JSON file & decode it<br/>

### URLs / HTTP
<code>file_url_exists</code>     - Check if file exists in provided url<br/>
<code>get_base_url</code>        - Return system base URL<br/>
<code>is_secure</code>           - Check if using HTTPS protocol<br/>

### MySQL
<code>mysql_timestamp</code>     - Return MySQL timestamp formated date/time<br/>

### Numbers & Characters
<code>ordinal</code>             - Return number as ordinal<br/>
<code>schars_replace</code>      - Remove special characters<br/>
