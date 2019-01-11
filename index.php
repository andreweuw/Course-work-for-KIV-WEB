<?php
mb_internal_encoding("UTF-8");

function autoLoad($class) {
        if (preg_match('/Controller$/', $class)) {
            require("controllers/" . $class . ".php");
        }
        else {
            require("models/" . $class . ".php");
        }
}

spl_autoload_register("autoLoad");

$router = new routerController();
$router->processParams(array($_SERVER['REQUEST_URI']));
$router->printView();