<?php

function dd($value) {
  echo '<pre>';
  var_dump($value);
  echo '</pre>';
  die();
}

function view($pathToView, $podaci = []) {
  extract($podaci);
  require __DIR__ . "/../views/{$pathToView}";
}

function redirect($path) {
  header('Location: ' . $path);
}