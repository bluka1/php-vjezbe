<?php

require __DIR__ . '/../../models/Article.php';

$articleModel = new Article();
$articles = $articleModel->getAll();

view('articles/index.view.php', [
  'articles' => $articles
]);