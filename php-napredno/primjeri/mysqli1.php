<?php 

$dbhost = 'localhost:3306';
$korisnik = 'root';
$lozinka = 'Lozinka123.';
$baza = 'zaposlenici';
$konekcija = null;

try {
  $konekcija = mysqli_connect($dbhost, $korisnik, $lozinka, $baza);
  echo 'Uspješna konekcija';
  echo '<br>';
  $sqlUpit = 'SELECT ime, prezime FROM zaposlenici';

  $rezultati = mysqli_query($konekcija, $sqlUpit);

  if(mysqli_num_rows($rezultati) > 0) {
    while($row = mysqli_fetch_assoc($rezultati)) {
      echo 'Ime: ' . $row['ime'] . ' , prezime: ' . $row['prezime'] . '<br>';
    }
  } else {
    echo 'Ništa nismo dohvatili.';
  }
  
} catch(Exception $e) {
  echo 'Greška prilikom komunikacije s bazom: ' . $e->getMessage();
} finally {
  if ($konekcija) {
    mysqli_close($konekcija);
  }
}


/*
Teorijska pozadina:
1. moram napraviti php skriptu da bih mogao neki kod
2. ta skripta mora sadržavati kod za spajanje na bazu
3. moramo dohvatiti podatke iz baze
4. moramo ispisati podatke iz baze
*/


/*
Konkretni koraci:
1. ostvariti konekciju na bazu
2. napraviti query na bazu
3. zawrappati kod u try-catch-finally
4. iterirati kroz rezultate - vježbati, proučiti stack overflow, pitati AI da mi pomogne oko ovoga
4.1. ispisati sve podatke iz pojedinog retka
*/