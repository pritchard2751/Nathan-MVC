<?php
$routes = array('routes' => array());

$routes['default_controller'] = 'home';
$routes['default_action'] = 'index';
$routes['404_controller'] = 'error';
$routes['404_action'] = 'index';

$routes['routes']['home'] = array('index');
$routes['routes']['about'] = array('index');
$routes['routes']['error'] = array('index','templateMissing', 'viewMissing');