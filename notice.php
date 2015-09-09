<?php 
    require './php_resources/check_session.php';
	require './php_resources/dbConn.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>PartySmile - Just have fun! - Notizie</title>
<link href="./CSS/sitestyle.css" rel="stylesheet" type="text/css">
</head>

<body>

<div class="container">
  <?php require("header.php"); ?>
  <div class="sidebar">
    <ul class="nav">
      <li><a href="home.php">Il tuo profilo</a></li>
      <li><a href="news.php">Notizie</a></li>
      <li><a href="friends.php">Amici</a></li>
      <li><a href="pictures.php">Foto</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <!-- end .sidebar1 --></div>
  <div class="content">
    <h1>Notifiche</h1>
    
    <h3>Richieste di amicizia</h3>
    
    <?php 
	
	dbConnect();
	$qry = "SELECT sender,state FROM richiesteamicizia WHERE receiver = '".$_SESSION['username']."' AND state = 1";
    $check = mysql_query($qry);
	$numberRows= mysql_num_rows($check);
	
	if($numberRows>0){
		echo ("<ul>");
		while($info = mysql_fetch_array($check))
			echo ("<li><a href=\"php_resources/acceptFriendRequest.php?sender=".$info['sender']."\">Accetta</a> o <a href=\"php_resources/refuseFriendRequest.php?sender=".$info['sender']."\">Rifiuta</a> la richiesta di amicizia di ".$info['sender']."</li>");
	
		echo ("</ul>");
	}else 
		echo("<p class=\"info2\">Non hai ricevuto alcuna richiesta di amicizia</p>");
	
	?>
    
    <!-- end .content --></div>
    <div class="sidebar">
  <ul class="nav">
    	 <li><a href="personalinformation.php">Informazioni personali</a></li>
      <li class="selected">Notifiche</li>
      <?php if($_SESSION['administrator']==1)
	  echo("<li><a href=\"administrationpanel.php\">Amministrazione sito</a></li>")?>
    </ul>
    <!-- end .sidebar2 --></div>
  <?php require("footer.php");?>
  <!-- end .container --></div>
</body>
</html>