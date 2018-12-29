<?php
/*
 * Purpose: controller for the URL access errors of the app.
 */

namespace Controllers;

class ErrorController extends \Core\helpers\BaseController
{
    public function __construct($action, $urlValues)
    {
        parent::__construct($action, $urlValues);

        //create model object
        $this->model = new \Models\ErrorModel;
    }

    public function badURL()
    {
        $this->view->output($this->model->badURL());
    }

    public function templateMissing()
    {
        $this->view->output($this->model->templateMissing());
    }

    public function viewMissing()
    {
        $this->view->output($this->model->viewMissing());
    }
}
