<?php
require_once '../core/Autoloader.php';
require_once '../core/Router.php';
//session_start(); // Si tu veux gérer l'auth plus tard

$router = new Router();
$router->run();
