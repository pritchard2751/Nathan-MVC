<?php

namespace Core\helpers;

class BaseController
{
    protected $urlParser = null;
    protected $model = null;
    protected $view = null;
    protected $action = '';

    public function __construct(string $action, URLParser $urlParser)
    {
        $this->action = $action;
        $this->urlParser = $urlParser;

        $class_name = get_class($this);

        // instantiate the view object
        // the class name relates to the sub-folder in the 'views' folder
        // the action relates to the file name within the sub-folder
        // TODO: consider setting the model in here, with the ability to override in the class?
        $this->view = new View($class_name, $action);
    }

    // TODO: Need to consider a basic way of protecting routes and where to do it
    // public function protect($sessionNames)
    // {
    //     $redirectTo = array("controller" => "login",
    //         "action" => "index");

    //     foreach ($sessionNames as $session) {
    //         if (!isset($_SESSION[$session])) {
    //             $this->redirect($redirectTo);
    //         }
    //     }

    //     return;
    // }

    public function executeAction()
    {
        if(!method_exists($this, $this->action)) {
            $this->redirect(array('controller' => 'error'));
        }

        $params = $this->urlParser->getAddtionalURLParams();
        call_user_func_array(array($this, $this->action), $params);
    }

    public function redirect(array $redirect_to)
    {
        $url = $this->urlParser->constructURL($redirect_to);
        header("Location:" . $url);

        exit;
    }

}
