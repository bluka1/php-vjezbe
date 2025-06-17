<?php

$dbhost = 'localhost';
$korisnik = 'vasKorisnik';
$lozinka = 'vasaLozinka';
$baza = 'vasaBaza';

try {
  $pdo = new PDO("mysql:host={$dbhost};dbname={$baza}", $korisnik, $lozinka);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  $stmt = $pdo->prepare("SELECT * FROM zaposlenici");

  $stmt->execute();

  // dohvaćanje prvog zapisa
  $prviZapis = $stmt->fetch();
  foreach($prviZapis as $key => $value) {
    echo $key .  ' : ' . $value;
    echo '<br>';
  }

  echo '<hr>';

  // dohvaćanje ostalih zapisa
  while($row = $stmt->fetch()) {
    echo $row['ime'] . ' ' . $row['prezime'] . '<br>';
  }

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}