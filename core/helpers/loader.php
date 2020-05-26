<?php

namespace Core\helpers;

class Loader 
{
    private $routes = null;
    private $urlParser = null;
    private $controller_inst = null;
    private $controller = '';
    private $action = '';

    public function __construct(array $routes, URLParser $urlParser){
        $this->routes = $routes;
        $this->urlParser = $urlParser;

        $controller_value = $this->urlParser->getControllerValue();
        $action_value = $this->urlParser->getActionValue();

        if (empty($controller_value)) {
            $controller_value = $routes['default_controller'];
        }

        if (empty($action_value)) {
            $action_value = $routes['default_action'];
        }

        $this->controller = $controller_value;
        $this->action = $action_value;

        if(!$this->routeExists($this->routes, $this->controller, $this->action)) {
            $this->controller = $routes['404_controller'];
            $this->action = $routes['404_action'];
        }
    }

    private function makeControllerClassname(string $controller): string {
        $classname = ucfirst($controller) . 'Controller';
        return '\\Controllers\\' . $classname;
    }

    public function createControllerInstance(): void { 
        $classname = $this->makeControllerClassname($this->controller);
        $this->controller_inst = new $classname($this->action, $this->urlParser);
    }

    public function routeExists(array $routes, string $controller, string $action): bool {
        $routes = $routes['routes'];

        if (!array_key_exists($controller, $routes) || 
            !in_array($action, $routes[$controller])) {
                return false;
            }

        return true;
    }

    public function getController(): string {
        return $this->controller;
    }

    public function getAction(): string {
        return $this->action;
    }

    public function getControllerInstance(): BaseController {
        return $this->controller_inst;
    }
}
