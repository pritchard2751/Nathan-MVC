<?php
/*
 * Purpose: abstract class from which controllers extend
 */

namespace Core\helpers;

class BaseController
{

    protected $urlValues;
    protected $action;
    protected $model;
    protected $view;

    /**
     * Sets action
     * Sets urlValues
     * @param string $action requested action
     * @param array[] $urlValues other URL parameters
     * @param array[] $sessionNames list of session names that must be set in order to access a URL/page
     */
    public function __construct($action, $urlValues, $sessionNames = array())
    {
        $this->action = $action;
        $this->urlValues = $urlValues;

        //re-direct if specified sessions are not set
        if (!empty($sessionNames)) {
            $this->protect($sessionNames);
        }

        $className = get_class($this);

        //instantiate the view object
        //the class name relates to the sub-folder in the 'views' folder
        //the action relates to the file name within the sub-folder
        $this->view = new view($className, $action);
    }

    public function protect($sessionNames)
    {
        $redirectTo = array("controller" => "login",
            "action" => "index");

        foreach ($sessionNames as $session) {
            if (!isset($_SESSION[$session])) {
                $this->redirect($redirectTo);
            }
        }

        return;
    }

    /**
     * Execute the requested action
     * @param array[] additional URL parameter key/value pairs
     */
    public function executeAction($params)
    {
        call_user_func_array(array($this, $this->action), $params);
    }

    public function redirect($params)
    {
        if (is_array($params)) {

            $url = "?c=" . $params["controller"] . "&a=" . $params["action"];

            if (isset($params["params"]) && is_array($params["params"])) {
                foreach ($params["params"] as $param => $value) {
                    $url .= "&" . $param . "=" . $value;
                }
            }

            header("Location:" . $url);

        } else if ($params == "error") {

            $redirectTo = array(
                "controller" => "error",
                "action" => "badURL",
            );

            $this->redirect($redirectTo);
        }

        exit;
    }

}
