<?php

$articles = [
  [
    "title" => "Moji hobiji",
    "body" => "Moji hobiji su raznovrsni. Volim programirati i baviti se sportom te puno drugih stvari."
  ],
  [
    "title" => "Moja hrana",
    "body" => "Volim hranu. Volim jesti. Volim kuhati."
  ],
  [
    "title" => "Moje namirnice",
    "body" => "Moji najdraže namirnice su: banane, mlijeko, med."
  ]
];
?>

<?php require 'views/partials/head.php' ?>

<div class="container mt-4">
  <?php foreach($articles as $article) :?>
    <div class="rounded border p-4 border-dark m-4">
      <h2><?= $article['title'] ?></h2>
      <p><?= $article['body'] ?></p>
    </div>
  <?php endforeach; ?>
</div>

<?php require 'views/partials/foot.php' ?>