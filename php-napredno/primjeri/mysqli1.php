<?php 

$dbhost = 'localhost:3306';
$korisnik = 'vasKorisnik';
$lozinka = 'vasaLozinka';
$baza = 'zaposlenici';
$konekcija;

try {

  $konekcija = mysqli_connect($dbhost, $korisnik, $lozinka, $baza);
  
  echo 'Uspješna konekcija';
  
  mysqli_close($konekcija);

} catch(Exception $e) {
  echo $e->getMessage();
}