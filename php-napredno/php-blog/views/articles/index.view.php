<?php require 'views/partials/head.php' ?>

<div class="container mt-4">
  <?php foreach($articles as $article) :?>
    <article class="rounded border p-4 border-dark m-4">
      <h2><?= $article['naslov'] ?></h2>
      <p><?= $article['tijelo'] ?></p>
      <small><?= $article['createdAt'] ?></small>
      <p>ID članka: <?= $article['id'] ?></p> 
      <!-- ovaj paragraph iznad ne treba biti u viewu
        ID je ovdje samo da osvjestite da on postoji u podacima koje smo proslijedili viewu
      -->
      <form action="/articles-delete" method="POST">
        <input type="hidden" name="id" value="<?=$article['id']?>">
        <input type="submit" value="Obriši" />
      </form>
      <a href="/articles-edit?id=<?=$article['id']?>">Ažuriraj članak</a>
    </article>
  <?php endforeach; ?>
</div>

<?php require 'views/partials/foot.php' ?>