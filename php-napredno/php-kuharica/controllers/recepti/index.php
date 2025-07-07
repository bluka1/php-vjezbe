<?php

require __DIR__ . '/../../models/Recepti.php';

$receptiModel = new Recepti();

$recepti = $receptiModel->getAll();
$receptiVal = array_values($recepti);

view('recepti/index.view.php', [
  'recepti' => $receptiVal
]);