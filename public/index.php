<?php

define('ROOT_PATH', realpath('../'));
define('PUBLIC_PATH', realpath('./'));
define('APP_PATH', ROOT_PATH.'/app/');
define('CORE_PATH', ROOT_PATH.'/core/');
define('DEBUG', true);

include_once(CORE_PATH.'Autoload.php');

(new \core\Autoload())->register();

(new core\App())->run();