<?php
/*
 * Purpose: model for the error controller.
 */

namespace Models;

class ErrorModel extends \Core\helpers\BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function badURL()
    {
        $this->viewModel->__set("pageTitle", "ERROR - Bad URL");
        return $this->viewModel;
    }

    public function templateMissing()
    {
        $this->viewModel->__set("pageTitle", "ERROR - Template Missing");
        return $this->viewModel;
    }

    public function viewMissing()
    {
        $this->viewModel->__set("pageTitle", "ERROR - View Missing");
        return $this->viewModel;
    }
}
