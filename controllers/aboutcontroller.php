<?php
/*
* Purpose: controller for the about page of the app.
*/

namespace Controllers;

class AboutController extends \Core\helpers\BaseController
{
    public function __construct($action, $urlValues)
    {
        parent::__construct($action, $urlValues);

        $this->model = new \Models\AboutModel;
    }

    public function index($sid = null)
    {
        $this->view->output($this->model->index($sid));
    }
}
