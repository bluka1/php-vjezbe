<?php

$dbhost = 'localhost';
$korisnik = 'vasKorisnik';
$lozinka = 'vasaLozinka';
$baza = 'vasaBaza';

// maknuto iz try-catch bloka radi jednostavnijeg čitanja koda
$pdo = new PDO("mysql:host={$dbhost};dbname={$baza}", $korisnik, $lozinka);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

try {
  // pokreni transkaciju - beginTransaction
  $pdo->beginTransaction();

  // kod koji želimo izvršiti u našoj transakciji
  $preparedStatement = $pdo->prepare("INSERT INTO odjeli (naziv) VALUES (:naziv)");
  $preparedStatement->execute([
    "naziv" => "Marketing"
  ]);

  echo 'Last inserted ID za Marketing:' . $pdo->lastInsertId();
  echo '<br>';
  $preparedStatement->execute([
    "naziv" => "Financije"
  ]);
  echo 'Last inserted ID za Financije:' . $pdo->lastInsertId();
  echo '<br>';

  $preparedStatement->execute([
    "naziv" => "Računovodstvo"
  ]);
  echo 'Last inserted ID za Računovodstvo:' . $pdo->lastInsertId();
  echo '<br>';

  $preparedStatement = $pdo->prepare("INSERT INTO place (iznos) VALUES (:iznos)");
  $preparedStatement->execute([
    "iznos" => 7500
  ]);
  echo 'Last inserted ID za plaće:' . $pdo->lastInsertId();
  echo '<br>';

  // spremi promjene - commit
  $pdo->commit();

} catch(PDOException $e) {
  // vrati na stanje prije početka transakcije - rollback
  $pdo->rollBack();
  throw $e;
}