<?php

use Quiz\Controllers\BaseController;

reguire_once '../src/bootstrap.php';

define('BASE_DIR', __DIR__ . '/..');
define('SOURCE_DIR', BASE_DIR. '/src');
define('VIEW_DIR', SOURCE_DIR . '/views');

$requestUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$requestString = substr($requestUrl, str($baseUrl));

$urlParams = explode('/',$requestString);

$controllerName = ucfirst(array_shift($urlParams));
$controllerName = $controllerName . ($controllerName ? $controllerName : 'Index') . 'Controller';

$actionName = strtolower(array_shift($urlParams));
$actionName = ($actionName ? $actionName : 'index') . 'Action';

/** @var BaseController $controller */
$controller = new $controllerName;
$controller->handleCall($actionName);