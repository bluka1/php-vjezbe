<?php

require __DIR__ . '/../../models/Article.php';
$articleModel = new Article();

$id = $_POST['id'];
$naslov = $_POST['naslov'];
$tijelo = $_POST['tijelo'];

$articleModel->updateById($id, $naslov, $tijelo);

redirect('/articles');