<?php
// Globalna varijabla
$a = 'Algebra';

function variableScope() {
    // Lokalna varijabla   
    $a = 'Backend developer';   
    // Ispis lokalne varijable
    echo $a;
}
// Ispis Globalne varijable
echo $a;

?>