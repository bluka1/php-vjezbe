<?php
// Čitanje sadržaja datoteke
$booksJson = file_get_contents(__DIR__. '/knjige.json');
// Transformiranje u niz
$books = json_decode($booksJson, true);
// Dodavanje novih podataka u niz
$books[] = [
    "title" => "One Hundred Years Of Solitude",        
    "author" => "Gabriel Garcia Marquez",        
    "available" => false,        
    "pages" => 457,        
    "isbn" => 9785267006323
];
// Transformiranje u JSON
$booksJson = json_encode($books);
// Zapisivanje novih podataka u datoteku
file_put_contents(__DIR__ . '/knjige.json', $booksJson); 
?>
