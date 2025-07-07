<?php

class Database {
  public $connection;

  public function __construct() {
    try {
      $this->connection = new PDO("mysql:host=localhost;dbname=receptidb", "root", "Lozinka123.");
      $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
      die("Neuspješna konekcija na bazu: {$e->getMessage()}");
    }
  }

  public function getConnection() {
    return $this->connection;
  }
}