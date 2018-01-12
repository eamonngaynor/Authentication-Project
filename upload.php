
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Website</title>
        <link rel="stylesheet" href="css/style.css">  
</head>


<?php
session_start();
if(!isset($_SESSION['login_user'])){
   header("Location:login.php");
}
?>

<h1>Upload image coming soon!</h1>