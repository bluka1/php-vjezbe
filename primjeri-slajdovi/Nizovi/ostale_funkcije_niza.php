<?php 
$properties = [    
    'firstname' => 'Tom',    
    'surname' => 'Riddle',    
    'house' => 'Slytherin' 
];
// Dohvaćanje ključeva elemenata niza
$keys = array_keys($properties); 
var_dump($keys);
// Dohvaćanje vrijednosti elemenata niza
$values = array_values($properties); 
var_dump($values);
// Brojanje elemenata niza
$size = count($properties); 
var_dump($size); // 3
// Spajanje dva niza u jedan
$good = ['Harry', 'Ron', 'Hermione']; 
$bad = ['Dudley', 'Vernon', 'Petunia']; 
$all = array_merge($good, $bad); 
var_dump($all);
?> 