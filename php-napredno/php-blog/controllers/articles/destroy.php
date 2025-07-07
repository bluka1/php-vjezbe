<?php

require __DIR__ . '/../../models/Article.php';
$articleModel = new Article();

$id = $_POST['id'];

$articleModel->deleteById($id);

redirect('/articles');