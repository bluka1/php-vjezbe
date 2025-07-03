<?php

function dd($value) {
  echo '<pre>';
  var_dump($value);
  echo '</pre>';
  die();
}

function view($pathToView, $podaci = []) {
  extract($podaci);
  require "views/{$pathToView}";
}

function redirect($path) {
  header('Location: ' . $path);
}