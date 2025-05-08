<?php 
// Inicijalizacija niza
$status = [    
    'name' => 'James Potter',    
    'status' => 'dead' 
];
// Uklanjanje elementa iz niza
unset($status['status']);
 
print_r ($status);
?>