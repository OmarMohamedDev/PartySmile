<?php
require './php_resources/dbConn.php';
	if ($dbFlag==false) {
		header("location: firstconnection.php");
	}


session_start();
if(isset($_SESSION["logged_in"])) 
header("location: justloggedin.php");
else
	session_destroy();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>PartySmile - Just have fun! - Welcome</title>
<link href="./CSS/sitestyle.css" rel="stylesheet" type="text/css">
</head>

<body>

<div class="container">
  <?php require("header.php"); ?>
  <div class="sidebar">
    <ul class="nav">
      <li><a href="login.php">Login</a></li>
      <li><a href="registration.php">Registrati</a></li>
    </ul>
    <p>Se è la prima volta che visiti PartySmile, inserisci i tuoi dati personali ed effettua la registrazione cliccando su "Registrati".</p>
    <p>In caso contrario, effettua il login.</p>
    <!-- end .sidebar1 --></div>
  <div class="content">
    <h1>Benvenuto su PartySmile!</h1>
    <p>PartySmile è un social network che ti permette di restare in contatto con i tuoi amici e condividere pensieri e immagini della tua vita.</p>
    <!-- end .content --></div>
 
 	<?php require("footer.php");?>
 
  <!-- end .container --></div>
</body>
</html>