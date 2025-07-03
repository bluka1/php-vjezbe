<?php require 'views/partials/head.php' ?>

<div class="container mt-4">
  <?php foreach($articles as $article) :?>
    <article class="rounded border p-4 border-dark m-4">
      <h2><?= $article['naslov'] ?></h2>
      <p><?= $article['tijelo'] ?></p>
      <small><?= $article['createdAt'] ?></small>
    </article>
  <?php endforeach; ?>
</div>

<?php require 'views/partials/foot.php' ?>