<?php
// Pokretanje sesije
session_start();
// Postavljanje sesijskih varijabli
$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo "Session variables are set.";
// Ispis vrijednosti sesijskih varijabli
echo "Favorite color is " . $_SESSION["favcolor"] . ".<br>";
echo "Favorite animal is " . $_SESSION["favanimal"] . ".";
print_r($_SESSION);
?>