<?php

namespace App\Controllers;

use \App\Core;

class HomeController {

  public function __construct() {
    
  }

  public function render() : void {

    ob_start();
    include __DIR__ . '/../Views/home/index.php';
    $data = [
      "ime" => "Franjo"
    ];

    $content = ob_get_clean();

    include __DIR__ . '/../Views/layouts/main.php';
  }
}