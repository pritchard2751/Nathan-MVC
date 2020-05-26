<?php

namespace Core\helpers;

class URLParser 
{
    const CONTROLLER_PARAM = 'c';
    const ACTION_PARAM = 'a';
    
    private $controller_value = '';
    private $action_value = '';
    private $params = array();

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

    private function getURLSeparator(string $str) : string {
       return (strpos($str, '?') === false) ? '?' : '&';
    }

    public function constructURL(array $redirect_to): string
    {
        $url = '';

        if(isset($redirect_to['controller'])){
            $s = $this->getURLSeparator($url);
            $url .= $s . self::CONTROLLER_PARAM . '=' . $redirect_to['controller'];
        } 

        if(isset($redirect_to['action'])) {
            echo "URL:  " . $url;
            $s = $this->getURLSeparator($url);
            $url .= $s . self::ACTION_PARAM . '=' . $redirect_to['action'];
        }

        if (isset($redirect_to['params'])) {
            foreach ($redirect_to['params'] as $param => $value) {
                $s = $this->getURLSeparator($url);
                $url .= $s . $param . '=' . $value;
            }
        }

        return $url;
    }

    public function getControllerValue(): string
    {
        return $this->controller_value;
    }

    public function getActionValue(): string 
    {
        return $this->action_value;
    }

    public function getAddtionalURLParams(): array
    {
        return $this->params;
    }
}