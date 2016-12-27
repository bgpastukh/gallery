<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('PUBLIC_DIR', dirname(dirname(__FILE__)).DS."public");
define('VIEWS_PATH', ROOT.DS.'views');

ini_set('display_errors', 1);
require_once '../bootstrap.php';