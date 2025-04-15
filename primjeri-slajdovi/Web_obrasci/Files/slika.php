<form action="" method="post" enctype="multipart/form-data">
Picture:
<input type="file" name="picture" />
<input type="submit" value="Send" />
</form>
<?php
$uploaddir = '/var/www/uploads/';
$uploadfile = $uploaddir . basename($_FILES['picture']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}
print_r($_FILES);
echo "</pre>";
?>