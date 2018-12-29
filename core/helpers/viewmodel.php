<?php
/*
 * Purpose: class for the optional data object returned by model methods which the controller sends to the view.
 */

namespace Core\helpers;

class ViewModel
{

    //dynamically adds a property or method to the ViewModel instance
    public function __set($name, $val)
    {
        $this->$name = $val;
    }

    //returns the requested property value
    public function __get($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        } else {
            return null;
        }
    }

    /**
     * create a new array property exist or add to existing array
     * @param string $name Name of the property
     * @param array[] $array array to be added to the property
     */
    public function push($name, $array)
    {
        if (isset($this->{$name})) {
            $this->$name = array_merge(array($this->__get($name)), array($array));
        } else {
            $this->__set($name, array($array));
        }
    }
}
