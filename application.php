<?php
include('settings.php');

// set correct timezone
ini_set('date.timezone', 'Asia/Calcutta');
date_default_timezone_set('Asia/Calcutta');

// Set default encoding for multibyte strings
mb_language('uni');
mb_internal_encoding('UTF-8');
mb_http_input('UTF-8');
mb_http_output('UTF-8');
mb_regex_encoding('UTF-8');

error_reporting(E_ALL ^ E_STRICT);
//Session::init();

// Define the Autoload function and register it as autoload
function loadModule($className) {
    $className = ltrim(preg_replace('/\\\\/', "/", $className), '/');
    
    if(file_exists(APP_ROOT.'modules/'.$className.'.php'))
        require_once(APP_ROOT.'modules/'.$className.'.php');
}
spl_autoload_register('loadModule');

set_include_path(implode(PATH_SEPARATOR, array(realpath(APP_ROOT.'libraries'), get_include_path())));
?>