<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';


spl_autoload_register(
    function ($class) {
        $class = str_replace("\\", "/", $class);
        include_once dirname(__FILE__) . "/../" . $class . ".php";
    }
);
