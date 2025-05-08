<?php 
// Inicijalizacija niza kao lista
$names = ['Harry', 'Ron', 'Hermione'];
// Pristup elementu
print_r($names[1]);
// Pristup elementu koji ne postoji
print_r($names[4]);

// Inicijalizacija niza kao mapa
$status = [    
    'name' => 'James Potter',    
    'status' => 'dead',
    'age' => 24 
];
// Pristup elementu
print_r($status['name']);
// Pristup elementu koji ne postoji
print_r($status['birthday']);
?>