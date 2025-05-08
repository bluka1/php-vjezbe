<?php
function addNumbers($a, $b, $printResult = false) {    
    $sum = $a + $b;    
    if ($printResult) {        
        echo 'The result is ' . $sum;    
    }    
    return $sum; 
}

$sum1 = addNumbers(1, 2); 
$sum1 = addNumbers(3, 4, false); 
$sum1 = addNumbers(5, 6, true); // it will print the result

?>