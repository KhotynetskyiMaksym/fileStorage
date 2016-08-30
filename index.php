<?php

//FRONT CONTROLLER

// GENERAL SETTINGS
ini_set('display_arrors', 1);
error_reporting(E_ALL);

session_start();

//INCLUDING FILES
define('ROOT', dirname(__FILE__));
require_once (ROOT.'/components/Autoload.php');

//call the Router
$router = new Router();
$router->run();