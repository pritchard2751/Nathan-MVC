<?php
/*
 * Purpose: model for the home controller.
 */

namespace Models;

class HomeModel extends \Core\helpers\BaseModel
{
    public function __construct()
    {
        parent::__construct(DB_PREFIX . "home");
    }

    public function index()
    {
        $this->viewModel->__set("pageTitle", "CustomMVCTemplate");
        $this->viewModel->__set("val", "This is the value of the 'val' variable set in the ViewModel");
        return $this->viewModel;
    }
}
