<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dodaj knjigu</title>
</head>
<body>
  <h1>Dodaj knjigu</h1>
  <hr>
  <?php
    // print_r($_POST);
    $knjigeContent = file_get_contents('./knjige.json');
    $knjige = json_decode($knjigeContent, true);
    // array_push($knjige, $_POST);

    $dodanaKnjiga = [
      'autor' => $_POST['autor'],
      'naslov' => $_POST['naslov'],
      'godina' => $_POST['godina']
    ];

    $knjige[] = $dodanaKnjiga; // kopiramo vrijednosti varijable POST i dodajemo ih u niz
    print_r($dodanaKnjiga);
    $knjigeJson = json_encode($knjige, JSON_UNESCAPED_UNICODE); // pretvorba niza u JSON format
    file_put_contents('./knjige.json', $knjigeJson);
  ?>
</body>
</html>