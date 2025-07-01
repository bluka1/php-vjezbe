<?php require 'views/partials/head.php' ?>

<form class="p-4">
  <div class="form-group">
    <label for="naslov">Naslov</label>
    <input type="text" class="form-control" id="naslov" name="naslov" placeholder="Vaš naslov">
  </div>
  <div class="form-group">
    <label for="body">Tijelo članka</label>
    <textarea class="form-control" id="body" name="body" rows="7" placeholder="Tekst članka...."></textarea>
  </div>
  <input type="submit" value="Dodaj članak" class="p-2 bg-primary rounded mt-4 text-white">
</form>

<?php require 'views/partials/foot.php' ?>