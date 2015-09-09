<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>PartySmile - Just have fun! - Logout</title>
<link href="./CSS/sitestyle.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php

//Pagina a cui si accede quando si effettua il logout

session_start();
session_unset();
session_destroy();
?>

<div class="container">
  <?php require("header.php"); ?>
  <div class="content">
    <h1>Logout effettuato!</h1>
    <p><a href="index.php">Torna alla pagina principale</a></p>
    <!-- end .content --></div>
  <?php require("footer.php");?>
  <!-- end .container --></div>
</body>
</html>