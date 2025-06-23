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

  $stmt = $pdo->prepare("INSERT INTO place (iznos) VALUES (:iznos)");

  $iznos = 6000;

  $stmt->bindParam(':iznos', $iznos);
  $stmt->execute();

  $iznos = 6500;
  $stmt->execute();

  $iznos = 7000;
  $stmt->execute();

  echo '<br>';
  echo '<br>';
  echo '<br>';
  echo '<br>';
  echo 'Uspješno izvršeni svi upiti na bazu!';

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}


// ZA ONE KOJI ZELE VJEZBATI:
// 1. napraviti jednostavnu web stranicu s vise html dokumenata
// 2. neka prva stranica bude uvod u vasu aplikaciju
// 3. neka se druga stranica zove popis zaposlenika i u njoj prikazite tablicu s podacima svih zaposlenika u vasoj
// 4. iduca stranica neka se zove opis placa i neka sadrzi popis placa iz vase baze
// 5. iduca stranica neka se zove voditelji odjela i neka sadrzava popis voditelja i podataka o voditeljima
// 6. iduca stranica neka bude forma za unos novih zapisa u bazu(zaposlenik ili placa ili sto vec zelite) i omogucite unos u bazu kroz svoju aplikaciju 