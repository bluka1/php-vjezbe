<?php

namespace App\Core;

class Database {
  private static $instance = null;
  private $connection;

  private function __construct() {
    try {
      $this->connection = new \PDO("mysql:host=localhost;dbname=vasaBaza", "vasUser", "vasaLozinka");
      $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      die("Neuspješna konekcija na bazu: " . $e->getMessage());
    }
  }

  public static function getInstance() {
    if (self::$instance === null) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  public function getConnection() {
    return $this->connection;
  }
}