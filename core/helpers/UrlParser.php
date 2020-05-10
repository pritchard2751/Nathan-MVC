<?php

namespace Core\helpers;

class URLParser 
{
    const CONTROLLER_PARAM = "c";
    const ACTION_PARAM = "a";

    public $controller_value = "";
    public $action_value = "";
    public $params = null;

    public function __construct($params) 
    {
        $this->params = $params;
        $this->setController();
        $this->setAction();
    }

    private function setController() 
    {
        if (isset($this->params[self::CONTROLLER_PARAM])) {
            $this->controller_value = $this->params[self::CONTROLLER_PARAM];
            unset($this->params[self::CONTROLLER_PARAM]);
        }
    }

    private function setAction() 
    {
        if (isset($this->params[self::ACTION_PARAM])) {
            $this->action_value = $this->params[self::ACTION_PARAM];
            unset($this->params[self::ACTION_PARAM]);
        }
    }

    public function getAddtionalURLParams() 
    {
        return $this->params;
    }

    public function getControllerValue() 
    {
        return $this->controller_value;
    }

    public function getActionValue() 
    {
        return $this->action_value;
    }
}