<?php

class Recepti {
  public $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function getAll() {
    $stmt = $this->db->connection->prepare("SELECT * FROM recepti");
    $stmt->execute();

    return $stmt->fetchAll();
  }
}