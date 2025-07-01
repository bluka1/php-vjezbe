<?php

namespace App\Core;

class Router {
  private $routes = [];

//  GET http://localhost:8000/ Controller index
//  POST http://localhost:8000/ Controller create

  public function addRoute($method, $path, $controller, $action) {
    $this->routes[] = [
      "method" => $method,
      "path" => $path,
      "controller" => $controller,
      "action" => $action
    ];
  }

  public function dispatch() {

  }

  private function matchPath($routePath, $url) {
    return $routePath === $url;
  }

}