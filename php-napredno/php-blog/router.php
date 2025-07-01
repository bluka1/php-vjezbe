<?php

require 'core/Database.php';

$db = Database::getInstance();


require 'functions.php';

$currentUri = $_SERVER['REQUEST_URI'];

if ($currentUri == '/') {
  require 'controllers/homeController.php';
} else if ($currentUri == '/articles') {
  require 'controllers/articlesController.php';
} else if ($currentUri == '/articles-create') {
  require 'controllers/articlesCreateController.php';
} else {
  require 'views/404.view.php';
}