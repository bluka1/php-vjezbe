<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Obrada-files</title>
</head>
<body>
  <h1>Obrada-files</h1>
  <hr>
  <?php
    // var_dump($_FILES);
    foreach($_FILES as $key => $value) {
      if (is_array($value)) {
        foreach($value as $k => $v) {
          print_r($k . ' : ' . $v . '<br>');
        }
      } else {
        print_r($key . ' : ' . $value . '<br>');
      }
    }


    $uploadDestination = __DIR__ . '/uploads/';
    
    if (isset($_FILES['slika'])) {
      $uploadedFile = $_FILES['slika'];
      //mime_content_type(); // check type of the file
      if (str_contains($uploadedFile['type'], 'image')) {
        move_uploaded_file($uploadedFile['tmp_name'], $uploadDestination . $uploadedFile['name']);
      } else {
        echo 'Datoteka nije slika.';
      }
    }
  ?>
</body>
</html>