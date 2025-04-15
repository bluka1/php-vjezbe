<?php 
echo "with while: "; 
$i = 1; 
while ($i < 0) {    
    echo $i . " ";    
    $i++; 
} 

echo "with do-while: "; 
$i = 1; 
do {    
    echo $i . " ";    
    $i++; 
} while ($i < 0);
?>