<?php

$dbhost = 'localhost:3306';
$korisnik = 'vasKorisnik';
$lozinka = 'vasaLozinka';
$baza = 'vasaBaza';

$mysqli = new mysqli($dbhost, $korisnik, $lozinka, $baza);

if (mysqli_connect_errno()) {
  echo 'Greška prilikom spajanja na bazu: ' . mysqli_connect_errno();
  exit();
}

$mysqli->autocommit(FALSE);

$mysqli->query("INSERT INTO place (iznos) VALUES (5000)");
$mysqli->query("INSERT INTO place (iznos) VALUES (5500)");

$mysqli->commit();

$mysqli->autocommit(TRUE);

$mysqli->close();