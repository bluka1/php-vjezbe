<?php
    $a = 10;
    $b = 0;
    
    // Vraća false pošto je varijabla a true
    var_dump (!$a);
    // Vraća false pošto je varijabla b false
    var_dump ($a && $b);
    // Vraća false pošto je varijabla b false
    var_dump ($a and $b);
    // Vraća true pošto je varijabla a true
    var_dump ($a || $b);
    // Vraća true pošto je varijabla a true
    var_dump ($a or $b);
?>