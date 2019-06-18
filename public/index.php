<?php

namespace MVC;

use MVC\LIB\FrontController;

ob_start();

session_start();

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

require_once '..' . DS . 'app' . DS . 'config.php';

require_once APP_PATH . DS . 'lib' . DS . 'autoload.php';

require_once APP_PATH . DS . 'template' . DS . 'head.php';

$frontController = new FrontController();
$frontController->dispatch();


require_once APP_PATH . DS . 'template' . DS . 'footer.php';
ob_end_flush();
