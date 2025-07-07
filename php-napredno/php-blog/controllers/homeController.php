<?php

class HomeController {
  public function index() {
    view('index.php', [
      'naslov' => 'Blog o programiranju'
    ]);
  }
}