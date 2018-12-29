<?php
/*
 * Project: Nathan MVC
 * File: index.php
 * Purpose: landing page which handles all requests
 * Authors: Sean Knox, Annie Pritchard, James Salmon
 */

session_name("MVVMCTemplate"); 
session_start();

require_once 'core/config/config.php';
require_once 'core/config/routes.php';
require_once __DIR__ . '/vendor/autoload.php';

//create the controller loader object
$controllerLoader = new \Core\helpers\Loader($routes);
//get additional URL parameters, that is, those not related to the controller or action
$params = $controllerLoader->getAdditionalParams();
//creates the requested controller object based on the 'controller' URL value
$controller = $controllerLoader->createController();
//execute the requested controller's requested method based on the 'action' URL value. Controller methods output a View.
$controller->executeAction($params);
