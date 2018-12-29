<?php
/*
 * Purpose: model for the about controller.
 */

namespace Models;

class AboutModel extends \Core\helpers\BaseModel
{
    public function __construct()
    {
        parent::__construct(DB_PREFIX . "about");
    }

    public function index($cid)
    {
        $this->viewModel->__set("pageTitle", "About page");
        $contributors = $this->getContributors();

        $this->viewModel->__set("contributors", $contributors);

        if (!is_null($cid)) {
            $this->viewModel->__set("contributors", $contributors[$cid]);
        }

        return $this->viewModel;
    }

    public function getContributors()
    {
        return array("Sean Knox", "Annie Pritchard", "James Salmon");
    }
}
