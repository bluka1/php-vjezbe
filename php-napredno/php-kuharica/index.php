<?php

require __DIR__ . '/core/functions.php';

require __DIR__ . '/core/Database.php';

$routes = require __DIR__ . '/routes.php';

$currentUri = $_SERVER['REQUEST_URI'];

require __DIR__ . "/controllers/" . $routes[$currentUri];