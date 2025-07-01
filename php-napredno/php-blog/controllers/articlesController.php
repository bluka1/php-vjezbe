<?php

// $articles = [
//   [
//     "title" => "Moji hobiji",
//     "body" => "Moji hobiji su raznovrsni. Volim programirati i baviti se sportom te puno drugih stvari."
//   ],
//   [
//     "title" => "Moja hrana",
//     "body" => "Volim hranu. Volim jesti. Volim kuhati."
//   ],
//   [
//     "title" => "Moje namirnice",
//     "body" => "Moji najdraže namirnice su: banane, mlijeko, med."
//   ]
// ]; // npr. dohvaćeni podaci iz baze

$conn = $db->getConnection();
$statement = $conn->prepare("SELECT * FROM clanci");
$result = $statement->execute();
$articles = $statement->fetchAll();

// dd($articles); // naslov, tijelo, createdAt

require 'views/articles.view.php';