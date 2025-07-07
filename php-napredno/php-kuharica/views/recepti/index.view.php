<?php require 'views/partials/head.php' ?>

<div class="container mt-4">
  <?php foreach($recepti as $recept) :?>
    <article class="rounded border p-4 border-dark m-4">
      <h2><?= $recept['naziv'] ?></h2>
      <p><?= $recept['sastojci'] ?></p>
      <p><?= $recept['postupak'] ?></p>
      <small><?= $recept['createdAt'] ?></small>
      <p>ID članka: <?= $recept['id'] ?></p> 
      <!-- ovaj paragraph iznad ne treba biti u viewu
        ID je ovdje samo da osvjestite da on postoji u podacima koje smo proslijedili viewu
      -->
      <form action="/recepti-delete" method="POST">
        <input type="hidden" name="id" value="<?=$recept['id']?>">
        <input type="submit" value="Obriši" />
      </form>
      <a href="/recepti-edit?id=<?=$recept['id']?>">Ažuriraj recept</a>
    </article>
  <?php endforeach; ?>
</div>

<?php require 'views/partials/foot.php' ?>