<?php

if (
  $_SERVER['REQUEST_METHOD'] === 'POST' &&
  !empty($_POST) && 
  isset($_POST['ime'])
  ) {
    $ime = htmlspecialchars($_POST['ime']);
    if (mb_strlen($ime) > 2) {
      $file_json = file_get_contents('people.json');
      $people = json_decode($file_json, true);
      $people[] = $ime;
      $people_json = json_encode($people, JSON_UNESCAPED_UNICODE, JSON_PRETTY_PRINT);
      file_put_contents('people.json', $people_json);
      header('Location: ' . '/');
    } else {
      die();
    }

    echo 'Bok ' . $ime;
} else {
  echo 'Niste poslali podatke.';
}