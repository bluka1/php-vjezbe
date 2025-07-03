<?php
$db = Database::getInstance();

$conn = $db->getConnection();
$statement = $conn->prepare("SELECT * FROM clanci");
$result = $statement->execute();
$articles = $statement->fetchAll();

view('articles/index.php', [
  'articles' => $articles
]);