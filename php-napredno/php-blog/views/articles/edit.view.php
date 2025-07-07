<?php require 'views/partials/head.php' ?>

<div class="container mt-4">
  <article class="rounded border p-4 border-dark m-4">
    <form action="/articles-store-edited" method="POST">
      <div class="mb-4">
        <label class='w-100'>Naslov:
          <input class="d-block w-100" type="text" name="naslov" value="<?= $article['naslov']?>" />
        </label>
      </div>
      <div class="mb-4">
        <label class='w-100'>Tijelo članka:
          <textarea name="tijelo" rows='5' class="d-block w-100"><?= $article['tijelo'] ?></textarea>
        </label>
      </div>
      <p>ID članka: <?= $article['id'] ?></p> 
      <!-- ovaj paragraph iznad ne treba biti u viewu
        ID je ovdje samo da osvjestite da on postoji u podacima koje smo proslijedili viewu
      -->
      <input type="hidden" name="id" value="<?=$article['id']?>">
      <input type="submit" value="Spremi promjene">
    </form>
  </article>
</div>

<?php require 'views/partials/foot.php' ?>