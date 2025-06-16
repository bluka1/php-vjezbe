<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <body>
    <form action="" method="post">
      <label for=""></label>
      <input type="text">
      <input type="number" name="" id="">
      <input type="password" name="" id="">
      <input type="email" name="" id="">
      <input type="file" name="" id="">
      <input type="radio" name="" id="">
      <input type="checkbox" name="" id="">
      <input type="submit" value="Posalji">
      <input type="date" name="" id="">
      <select name="" id=""></select>
      <textarea name="" id=""></textarea>
    </form>

    <table>
      <thead>
        <tr>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td></td>
          <td></td>
          <?php 
            foreach (range(1, 10) as $num) {
              echo '<tr>';
              echo '<td>' . $num . '</td>';
              echo '<td>' . $num * $num . '</td>';
              echo '</tr>';
            }
            echo '<tr>';
            echo '<td>' . date('d.m.Y') . '</td>';
            echo '<td>' . date('H:i:s') . '</td>';
            echo '</tr>';
          ?>

          <?php foreach($niz as $vrijednost): ?>
            <td><?php echo $vrijednost ?></td>
            <!-- <td>{{ $vrijednost }}</td> -->
          <?php endforeach; ?>

        </tr>
      </tbody>
    </table>

    <ul>
      <?php foreach($niz as $vrijednost): ?>
        <li><?php echo $vrijednost ?></li>
      <?php endforeach; ?>
    </ul>

    <ol>
      <li></li>
    </ol>

    <dl>
      <dt></dt>
      <dd></dd>
    </dl>

  </body>
</html>

<?php

$name;
$Name;

echo $name;
ECHO $Name;

// 
/*
  include '';
  include_once '';
  require '';
  require_once '';      
*/

// ISKAZ - naredba koja nesto radi
$num = 10;
// IZRAZ - kod koji vraca neku vrijednost
$num = 1 + 1; // 1 + 1 je izraz

$imeVarijable = 10;
$imeVarijable = 'Ime';

$naziv = 'jedanPlusJedan';

$ref = 'naziv';

$$ref = 'dvaPlusDva';
// $ref = 'naziv' i iz tog razloga se referiram na njenu vrijednost
// s obzirom da je njena vrijednost 'naziv', ovaj prvi znak $ se odnosi zapravo na varijablu $naziv

// konstante
define('DB_HOST', 'localhost');
echo DB_HOST;
echo constant('DB_HOST');

// KORISNE KONSTANTE
echo __FILE__; // path do trenutne datoteke
echo __DIR__; // path do direktorija u kojem se nalazi trenutna datoteka
echo __LINE__; // trenutna linija u kodu koji se izvrsava
echo __FUNCTION__; // ime funkcije koja se izvrsava
echo __CLASS__; // ime klase koja se izvrsava

// TIPOVI PODATAKA
// string
// integer
// float
// boolean
// array
// object

$varijabla = 10;
$varijabla = 'ime';
$varijabla = true;

// provjere 
var_dump(); // daje informaciju o tipu podatka
gettype(); // daje tip podatka
is_string(); 
is_int();
is_array();
is_bool();
// isset();
// empty();

// eksplicitne konverzije podataka
$tekst = '10';
$broj = (int)$tekst;

function zbroj($a, $b) {
  return $a + $b;
}

zbroj('2agkjfkj', '3'); // 5
zbroj(2, 3); // 5

var_dump(0 == '0'); // true
var_dump(0 == 'asdfgh'); // true
var_dump(true == 1); // true

// 0 - false
// 1 - true
// '0' - false
// '1' - true

echo '1' + '2' . '3'; // 33


var_dump(0 === '0'); // false

//declare(strict_types=1); // deklaracija tipova podataka (OBAVEZNO NA VRH FILEA)

// function zbroj (int $a, int $b) {
//   return $a + $b;
// }

zbroj('2', '3'); // greska

// OPERATORI
++$x; // pre-increment
$x++; // post-increment
--$x; // pre-decrement
$x--; // post-decrement

// > >= < <= == === != !== && || !

// ??
$x = $_POST['brojCipela'] ?? 45;

// NIZOVI
// asocijativni - key-value pair
$arr = [
  $key => $value,
  $key1 => $value1
];

$arr[] = [
  $key => $value
];

$arr['key1'] = $value1;

// numericki
$arr1 = [1,2,3,4,5];
$arr1[] = 6;

$arr1[0];

foreach($arr1 as $broj) {
  echo $broj;
}

foreach($arr as $key => $value) {
  echo $key . ' ' . $value;
}

// korisne funkcije
// count();
// sizeof();
// in_array();
// array_push();
// array_pop();
// array_shift();
// array_unshift();
// array_search();
// sort();
// array_filter();
// array_map();
// array_merge();
// empty();
// isset();

if (3 > 4) {
  // ovaj se ne izvrsava
} else {
  // ovaj se izvrsava jer 3 nije veci od 4
}

// npr
if ($stanjeNaRacunu > $trazeniIznos) {
  // isplati novac
} else {
  // nema dovoljno novca
}

if ($stanjeNaRacunu > $trazeniIznos) {
  // isplati novac
} else if ($stanjeNaRacunu === $trazeniIznos) {
  // isplati novac
} else {
  // nema dovoljno novca
}

$theme = $userSelectedTheme === 'dark' ? '.dark-theme' : '.light-theme';
// uvjet ? vracanje koda ako je uvjet true : vracanje koda ako je uvjet false;
echo $theme;

switch ($userSelectedTheme) {
  case 'dark':
    echo '.dark-theme';
    break;
  case 'light':
    echo '.light-theme';
    break;
  default:
    echo '.gray-theme';
}

// PETLJE - moraju imati counter(iterator), uvjet, increment/decrement

for ($i = 0; $i < 10; $i++) {
  if ($i % 2 === 0) {
    continue; // prelazi na sljedecu iteraciju odnosno preskace sve iduce korake u tijelu petlje
  }
  if ($i === 5) {
    break; // izlazi iz petlje
  }
  echo $i;
}

$counter = 0;
while($counter < 10) {
  echo $counter;
  $counter++;
}

function oduzmi($a, $b = 10) {
  // return $a - $b;
  echo 'oduzmi';
  return 1;
}

// oduzmi(20); // 10 -> b je po defaultu postavljen na 20

// function zbroj(int $a, int $b): int {
//   return $a + $b;
// }

$num = 0;
function povecaj(&$num) {
  $num++;
  echo $num;
}

povecaj($num); // 1

function sum() {
  return 1 + 1;
}

$varSum = 'sum';

echo $varSum();

// arrow funkcije
$zbrojiDvaBroja = fn($x, $y) => $x + $y;

// scope
$y = 10; // globalna promjenljiva

$globalnaVarijabla = 1;

$lojalniScope =  function() use ($globalnaVarijabla) {
  $y = 20; // lokalna varijabla
  $x = 5;

  // global $globalnaVarijabla; // referenca na globalnu varijablu
};

echo $x; // greska


// rad s datotekama
// file_get_contents(); - dohvacanje sadrzaja datoteke
// file_put_contents(); - zapisivanje sadrzaja datoteke

// json_encode();
// json_decode();


// super globalne varijable
// $_GET
// $_POST
// $_SERVER
// $_FILES
// $_SESSION
// $_COOKIE

?>