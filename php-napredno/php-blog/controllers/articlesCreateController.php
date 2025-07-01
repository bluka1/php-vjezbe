<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require __DIR__ . '/../functions.php';
  dd($_POST);
}

require 'views/articles-create.view.php';