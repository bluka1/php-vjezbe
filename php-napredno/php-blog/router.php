<?php

require 'functions.php';

$currentUri = $_SERVER['REQUEST_URI'];

if ($currentUri == '/') {
  require 'views/index.view.php';
} else if ($currentUri == '/articles') {
  require 'views/articles.view.php';
} else if ($currentUri == '/articles-create') {
  require 'views/articles-create.view.php';
}