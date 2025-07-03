<?php
require 'core/Database.php';
$db = Database::getInstance();

// function spl_autoload_register($class) {
//   return require "{$class}.php";
// }

require 'core/functions.php';

require 'core/Router.php';

$router = new Router();

require 'routes.php';

$currentUri = $_SERVER['REQUEST_URI'];
$router->route($currentUri);