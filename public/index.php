<?php

define('ROOT_PATH', realpath('../'));
define('PUBLIC_PATH', realpath('./'));
define('APP_PATH', ROOT_PATH.'/app/');
define('CORE_PATH', ROOT_PATH.'/core/');
define('DEBUG', true);

if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}


include_once(CORE_PATH.'Autoload.php');

(new \core\Autoload())->register();

(new core\App())->run();