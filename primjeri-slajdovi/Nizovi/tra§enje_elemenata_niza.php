<?php 
$names = ['Harry', 'Ron', 'Hermione'];

$containsHermione = in_array('Hermione', $names); 
var_dump($containsHermione); // true

$containsSnape = in_array('Snape', $names); 
var_dump($containsSnape); // false 

$wheresRon = array_search('Ron', $names); 
var_dump($wheresRon); // 1 

$wheresVoldemort = array_search('Voldemort', $names); 
var_dump($wheresVoldemort); // false
?>