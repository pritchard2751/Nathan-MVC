<?php

namespace Core\helpers;

class Loader {
    const DEFAULT_CONTROLLER_NAME = "home";
    const DEFAULT_ACTION = "index";

    public $urlParser = null;
    private $routes = null;
    private $controllerInstance = null;
    private $controllerName = "";
    private $classname = "";
    private $action = "";

    public function __construct(array $routes, $urlParser){
        $this->routes = $routes;
        $this->urlParser = $urlParser;
        $notFound = false;
        $controllerValueExists = !empty($this->urlParser->controllerValue);
        $actionValueExists = !empty($this->urlParser->actionValue);

        if (!$actionValueExists) {
            $this->urlParser->actionValue = self::DEFAULT_ACTION;
        }

        if($controllerValueExists && $actionValueExists){
            // TODO: verify and protect route
            $routeExists = $this->routeExists($this->routes, $this->urlParser->controllerValue, $this->urlParser->actionValue);
            if(!$routeExists){
                $notFound = true;
            } else {
                $this->controllerName = $this->urlParser->controllerValue;
                $this->action = $this->urlParser->actionValue;
            }

        } else if (!$controllerValueExists xor !$actionValueExists) {
            $notFound = true;
        }
        else {
            $this->controllerName = self::DEFAULT_CONTROLLER_NAME;
        }

        if($notFound) {
            $this->controllerName = "error";
            $this->action = "badURL";
        }
    }

    public function routeExists(array $routes, string $controller, string $action): bool {
        if (!array_key_exists($controller, $routes)
            || !in_array($action, $routes[$controller])) {
                return false;
            }

        return true;
    }

    public function createControllerInstance() { 
        $classname = $this->getControllerClassname($this->controllerName);
        $this->setControllerInstance($this->classname, $this->action, $this->urlParser->params);
        $namespace = '\\Controllers\\' . $classname;
        $this->controllerInstance = new $namespace($action, $params);
    }

    public function getControllerClassname(string $controllerName): string {
        return ucfirst($controllerName) . "Controller";
    }

    public function getControllerInstance(): BaseController {
        return $this->controllerInstance;
    }
}
