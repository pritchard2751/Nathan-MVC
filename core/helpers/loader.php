<?php
/*
 * Purpose: class which maps URL requests to controller object creation.
 */

namespace Core\helpers;

class Loader
{

    private $controllerName;
    private $controllerClass;
    private $action;
    private $urlValues;
    private $defaultControllerName;

    /**
     * Set controller name and class
     * Set current requested action
     * Set other URL values
     */
    public function __construct($routes, $dcn = "home")
    {
        $this->defaultControllerName = $dcn;
        $this->urlValues = $_GET;

        //if action is not set, default to index
        if (!isset($this->urlValues["a"]) || $this->urlValues["a"] == "") {
            $this->urlValues["a"] = "index";
        }

        //if both controller and action are set, check the URL parts against accepted routes
        if (isset($this->urlValues["c"]) && isset($this->urlValues["a"])) {
            //potential route
            $controller = $this->urlValues["c"];
            $action = $this->urlValues["a"];

            //verify route
            if (!array_key_exists($controller, $routes)
                || !in_array($action, $routes[$controller])) {
                $this->controllerName = "error";
                $this->action = "badURL";
            } else {
                $this->controllerName = $controller;
                $this->action = $action;
            }
        }
        //if either the controller or action is not set, show a 404 error
        else if (isset($_GET["c"])
            xor isset($_GET["a"])) {
            $this->controllerName = "error";
            $this->action = "badURL";
        }
        //send to the default page if no controller or action set
        else {
            $this->controllerName = $this->defaultControllerName;
            $this->action = "index";
        }

        $this->controllerClass = ucfirst($this->controllerName) . "Controller";
    }

    public function getAdditionalParams()
    {
        $array = array();

        foreach ($this->urlValues as $key => $value) {
            if ($key != "c" && $key != "a") {
                $array[$key] = $value;
            }
        }

        return $array;
    }

    public function createController()
    {
        $nameSpace = '\\Controllers\\' . $this->controllerClass;
        return new $nameSpace($this->action, $this->urlValues);
    }
}
