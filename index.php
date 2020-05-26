<?php

session_name("MVVMCTemplate"); 
session_start();

require_once 'vendor/autoload.php';
require_once 'core/config/config.php';
require_once 'core/config/routes.php';

$urlParser = new \Core\helpers\URLParser($_GET);
$params = $urlParser->getAddtionalURLParams();
$controllerLoader = new \Core\helpers\Loader($routes, $urlParser);

try {
    $controllerLoader->createControllerInstance($params);
} catch (Error $e) {
    echo $e->getMessage();
    die('TODO');
}

$controllerInstance = $controllerLoader->getControllerInstance();
$controllerInstance->executeAction();

