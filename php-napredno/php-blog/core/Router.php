<?php

// namespace Core;

class Router {
  private $routes = [];

  public function addRoute(string $method, string $uri, string $controller) {
    $this->routes[] = [
      'uri' => $uri,
      'controller' => $controller,
      'method' => $method
    ];
  }

  public function get($uri, $controller) {
    $this->addRoute('GET', $uri, $controller);
  }

  public function post($uri, $controller) {
    $this->addRoute('POST', $uri, $controller);
  }
  public function delete($uri, $controller) {
    $this->addRoute('POST', $uri, $controller);
  }
  public function put($uri, $controller) {
    $this->addRoute('POST', $uri, $controller);
  }

  public function route(string $currentUri, string $method) {
    foreach($this->routes as $route) {
      if ($currentUri === $route['uri'] && $method === $route['method']) {
        return require __DIR__ . "/../controllers/{$route['controller']}";
      }
    }

    require __DIR__ . '/../views/404.view.php';
  }
}