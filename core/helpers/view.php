<?php
/*
 * Purpose: class for the view object.
 */

namespace Core\helpers;

class View
{
    protected $viewFile;

    /**
     * Determine the correct viewFile based on the controller class name
     *
     * @param string $contrClass Name of controller class
     * @param string $action Name of action
     */
    public function __construct($contrClass, $action)
    {
        $contrClass = str_replace("Controllers\\", "", $contrClass);
        $contrClass = str_replace("Controller", "", $contrClass);
        $this->viewFile = "views/" . $contrClass . "/" . $action . ".php";
    }

    /**
     * @param viewModel $viewModel This holds the data for use in the view
     * @param string $template Name of the template file to use
     */
    public function output($viewModel, $template = "template")
    {
        //the template file includes a header, the view file, and a footer
        $templateFile = "views/common//" . $template . ".php";

        if (file_exists($this->viewFile)) {
            if ($template) {
                if (file_exists($templateFile)) {
                    require $templateFile;
                } else {
                    require 'views/error/badtemplate.php';
                }
            } else {
                require $this->viewFile;
            }
        } else {
            require 'views/error/badview.php';
        }
    }
}
