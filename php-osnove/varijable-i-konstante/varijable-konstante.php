<?php
// Definiranje varijabli
$integer = 10;
$float = 2.5;
$string = 'Algebra';
$bool = true;
// Ispis varijabli
echo $integer, $float, $string, $bool;
// Konstante
define('PITAGORA', 1.41);
define('TEODOR', 1.73);
// Ispis konstanti
print PITAGORA;
print TEODOR;
// Reference
$a = 5;
$b = &$a;
print $b;
$a = 10;
print $b;
?>