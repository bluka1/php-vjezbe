<?php
// This is a wrapper function around echo
function echoIt($string)
{
    echo $string;
}

$func = 'echoIt';
$func('test');  // This calls echoIt()
?>