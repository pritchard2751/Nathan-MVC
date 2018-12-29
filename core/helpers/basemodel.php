<?php
/*
 * Purpose: abstract class from which models extend.
 */

namespace Core\helpers;

class BaseModel
{
    protected $viewModel;

    public function __construct($dbtname = null)
    {
        $modelName = strtolower(get_class($this));

        if (is_null($dbtname) == false) {
            $this->table = $dbtname;
        } else {
            $this->table = DB_PREFIX . $modelName . "s";
        }

        $this->viewModel = new viewmodel();
        $this->commonViewData();
    }

    public function commonViewData()
    {
        //place all common view data here
    }
}
