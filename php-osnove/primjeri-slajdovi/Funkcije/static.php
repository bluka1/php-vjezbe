<?php
function staticScope()
{
    static $a = 0;
    echo $a;
    $a++;
}
// Višestruko pozivanje funkcije
staticScope();
staticScope();
staticScope();
?>