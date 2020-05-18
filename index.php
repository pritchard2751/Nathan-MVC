<?php

session_name("MVVMCTemplate"); 
session_start();

require_once 'vendor/autoload.php';
require_once 'core/config/config.php';
require_once 'core/config/routes.php';

$urlParser = new \Core\helpers\URLParser($_GET);
$controllerLoader = new \Core\helpers\Loader($routes, $urlParser);
$controllerLoader->createControllerInstance();
$controllerInstance = $controllerLoader->getControllerInstance();
$controllerInstance->executeAction();

