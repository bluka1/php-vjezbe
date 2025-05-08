<?php 
$names = ['Harry', 'Ron', 'Hermione']; 
foreach ($names as $name) {    
    echo $name . " "; 
} 
foreach ($names as $key => $name) {   
     echo $key . " -> " . $name . " "; 
}
?>