<?php

require __DIR__ . '/../../models/Article.php';

$id = $_GET['id'];

$articleModel = new Article();

$article = $articleModel->getById($id);

view('articles/edit.view.php', [
  'article' => $article
]);