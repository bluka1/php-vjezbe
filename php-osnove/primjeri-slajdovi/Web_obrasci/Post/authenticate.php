<?php 
$submitted = !empty($_POST); 
?>
<p>Form submitted? <?php echo (int) $submitted; ?></p>    
<p>Your login info is</p>
<ul>        
    <li><b>username</b>: <?php echo $_POST['username']; ?></li>
    <li><b>password</b>: <?php echo $_POST['password']; ?></li>
</ul>