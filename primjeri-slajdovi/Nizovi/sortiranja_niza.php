<?php 
// Inicijalizacija niza
$properties = [    
    'firstname' => 'Tom',    
    'surname' => 'Riddle',    
    'house' => 'Slytherin' 
];
// dupliciranje niza u nove varijable
$properties1 = $properties2 = $properties3 = $properties;
// sortiranje po vrijednosti uzlazno
// ključevi se resetiraju
sort($properties1); 
var_dump($properties1);
// sortiranje po vrijednosti uzlazno
// zadržava prvotne ključeve
asort($properties3); 
var_dump($properties3);
// sortiranje po ključu uzlazno
ksort($properties2); 
var_dump($properties2);
?>