<?php
/*
 * Purpose: controller for the home of the app.
 */

namespace Controllers;

class HomeController extends \Core\helpers\BaseController
{
    public function __construct($action, $urlValues)
    {
        parent::__construct($action, $urlValues);
        $this->model = new \Models\HomeModel;
    }
    
    //default method
    public function index()
    {
        $this->view->output($this->model->index());
    }
}
