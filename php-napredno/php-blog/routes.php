<?php

$routes = [
  '/' => 'controllers/homeController.php',
  '/articles' => 'controllers/articlesController.php',
  '/articles-create' => 'controllers/articlesCreateController.php'
];

foreach($routes as $path => $controller) {
  $router->addRoute($path, $controller);
}