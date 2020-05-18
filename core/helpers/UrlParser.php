<?php

namespace Core\helpers;

class URLParser 
{
    const CONTROLLER_PARAM = 'c';
    const ACTION_PARAM = 'a';
    
    private $controller_value = '';
    private $action_value = '';
    private $params = null;

    public function __construct($params) 
    {
        $this->params = $params;
        $this->configController();
        $this->configAction();
    }

    private function configController() 
    {
        if (isset($this->params[self::CONTROLLER_PARAM])) {
            $this->controller_value = $this->params[self::CONTROLLER_PARAM];
            unset($this->params[self::CONTROLLER_PARAM]);
        }
    }

    private function configAction() 
    {
        if (isset($this->params[self::ACTION_PARAM])) {
            $this->action_value = $this->params[self::ACTION_PARAM];
            unset($this->params[self::ACTION_PARAM]);
        }
    }

    public function getControllerValue() 
    {
        return $this->controller_value;
    }

    public function getActionValue() 
    {
        return $this->action_value;
    }

    public function getAddtionalURLParams() 
    {
        return $this->params;
    }
}