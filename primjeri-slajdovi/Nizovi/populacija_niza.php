<?php 
// Niz kao lista
$names = ['Harry', 'Ron', 'Hermione'];
// Niza kao mapa
$status = [    
    'name' => 'James Potter',    
    'status' => 'dead',
    'age' => 24 
]; 
// Dodavanje novog elementa na kraj niza
$names[] = 'Neville';
// Nadjačavanje ključa u nizu
$status['age'] = 32; 

print_r($names, $status);
?>