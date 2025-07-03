<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require __DIR__ . '/../core/Database.php';
  $db = Database::getInstance();
  require __DIR__ . '/../core/functions.php';

  // validacija inputa - DZ

  $naslov = $_POST['naslov'];
  $tijelo = $_POST['body'];

  $conn = $db->getConnection();

  $stmt = $conn->prepare("INSERT INTO clanci (korisnikId, naslov, tijelo) VALUES (1, :naslov, :tijelo)");

  $stmt->bindParam(':naslov', $naslov);
  $stmt->bindParam(':tijelo', $tijelo);

  $stmt->execute();

  // redirect korisnika na sve clanke
  redirect('/articles');
}

view('articles/create.php');