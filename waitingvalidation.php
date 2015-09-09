<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>PartySmile - Just have fun! - Logout</title>
<link href="./CSS/sitestyle.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php 
session_start();
session_unset();
session_destroy();
?>

<div class="container">
  <?php require("header.php"); ?>
  <div class="content">
    <h1>In attesa di validazione</h1>
    <p>Hai completato con successo la procedura di registrazione ed il tuo account è ora in attesa di essere validato da un'amministratore di PartySmile.</p>
    <p>Se la procedura di validazione andrà a buon fine, potrai iniziare ad utilizzare tutte le funzionalità di PartySmile.</p>
    <p>Ti invitiamo a riprovare ad accedere al sito più tardi.</p>
    <p><a href="index.php">Torna alla pagina principale</a></p>
    <!-- end .content --></div>
  <?php require("footer.php");?>
  <!-- end .container --></div>
</body>
</html>