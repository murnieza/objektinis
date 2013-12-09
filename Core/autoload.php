<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

function KTIT_autoloader($class)
{
    $class = str_replace("\\", "/", $class);
    include_once dirname(__FILE__) . "/../" . $class . ".php";
}

spl_autoload_register("KTIT_autoloader");
