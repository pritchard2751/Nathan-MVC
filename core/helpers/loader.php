<?php

namespace Core\helpers;

class Loader {
    const DEFAULT_CONTROLLER_NAME = 'home';
    const DEFAULT_ACTION = 'index';

    public $urlParser = null;
    private $routes = null;
    private $controllerInstance = null;
    private $controllerName = '';
    private $classname = '';
    private $action = '';

    public function __construct(array $routes, $urlParser){
        $this->routes = $routes;
        $this->urlParser = $urlParser;
        $notFound = false;

        $controllerValue = $this->urlParser->getControllerValue();
        $actionValue = $this->urlParser->getActionValue();

        if (empty($actionValue)) {
            $actionValue = self::DEFAULT_ACTION;
            $this->action = $actionValue;
        }

        if(!empty($controllerValue) && !empty($actionValue)){
            $routeExists = $this->routeExists($this->routes, $controllerValue, $actionValue);
            if(!$routeExists){
                $notFound = true;
            } else {
                $this->controllerName = $controllerValue;
                $this->action = $actionValue;
            }
        } else if (empty($controllerValue)) {
            $this->controllerName = self::DEFAULT_CONTROLLER_NAME;
        }

        if($notFound) {
            $this->controllerName = 'error';
            $this->action = 'badURL';
        }
    }

    // TODO: move verify and protect route elsewhere 
    public function routeExists(array $routes, string $controller, string $action): bool {
        if (!array_key_exists($controller, $routes)
            || !in_array($action, $routes[$controller])) {
                return false;
            }

        return true;
    }

    public function createControllerInstance() { 
        $classname = $this->makeControllerClassname($this->controllerName);
        $this->setControllerInstance($this->classname, $this->action, $this->urlParser->params);
        $namespace = '\\Controllers\\' . $classname;
        $this->controllerInstance = new $namespace($action, $params);
    }

    public function makeControllerClassname(string $controllerName): string {
        return ucfirst($controllerName) . "Controller";
    }

    public function getControllerName(): string {
        return $this->controllerName;
    }

    public function getAction(): string {
        return $this->action;
    }

    public function getControllerInstance(): BaseController {
        return $this->controllerInstance;
    }
}
