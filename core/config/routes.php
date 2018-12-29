<?php

//define accepted controller => action routes
$routes = array(
    "home" => array("index"),
    "about" => array("index"),
    "error" => array("badURL",
        "templateMissing",
        "viewMissing"),
);
