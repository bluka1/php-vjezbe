<?php

require __DIR__ . '/../../models/Article.php';
$articleModel = new Article();
// validacija inputa - DZ

$naslov = $_POST['naslov'];
$tijelo = $_POST['body'];

$articleModel->create($naslov, $tijelo);

// redirect korisnika na sve clanke
redirect('/articles');