<?php 
    require './php_resources/check_session.php';
	require './php_resources/dbConn.php';
	require './php_resources/function.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>PartySmile - Just have fun! - I tuoi amici</title>
<link href="./CSS/sitestyle.css" rel="stylesheet" type="text/css">
</head>

<body>

<div class="container">
  <?php require("header.php"); ?>
  <div class="sidebar">
    <ul class="nav">
      <li><a href="home.php">Il tuo profilo</a></li>
      <li><a href="news.php">Notizie</a></li>
      <li class="selected">Amici</li>
      <li><a href="pictures.php">Foto</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <!-- end .sidebar1 --></div>
  <div class="content">
    <h1>Amici</h1>
    
    <p class="info">(<a href="findfriends.php">Cerca nuovi amici</a>)</p>
<?php
dbConnect();
$qry = "SELECT sender,receiver FROM richiesteamicizia WHERE (sender = '".$_SESSION['username']."' OR receiver = '".$_SESSION['username']."') AND state = 2";
	$check = mysql_query($qry);
	$numberRows= mysql_num_rows($check);
	$friendFound="";

if($numberRows>0){
	echo("<ul>");
	
	while($info = mysql_fetch_array($check)){
		
	if($info['sender']!=$_SESSION['username'])
		$friendFound=$info['sender'];
	else
		$friendFound=$info['receiver'];
		 echo "<li><a href=\"userfriend.php?friend=",$friendFound,"\">",$friendFound,"</a></li>";
	}
	echo("</ul>"); 
	}
	
else
	echo("<p class=\"info2\">Non è presente nessun utente di PartySmile nella tua lista degli amici.</p>");
	
	mysql_close();
?>
                     
    <!-- end .content --></div>
    <div class="sidebar">
  <ul class="nav">
    	 <li><a href="personalinformation.php">Informazioni personali</a></li>
        <?php 
	  dbConnect();
	 $qry = "SELECT sender,state FROM richiesteamicizia WHERE receiver = '".$_SESSION['username']."' AND state = 1";
     $check = mysql_query($qry);
     $numberRows= mysql_num_rows($check);
	  
	  if($numberRows==0){ ?>
      <li><a href="notice.php">Notifiche (0)</a></li>
      <?php }
	  else { ?>
      <li><a href="notice.php">Notifiche (<?php echo $numberRows;?>)</a></li>
      <?php } if($_SESSION['administrator']==1)
	  echo("<li><a href=\"administrationpanel.php\">Amministrazione sito</a></li>")?>
    </ul>
    <!-- end .sidebar2 --></div>
  <?php require("footer.php");?>
  <!-- end .container --></div>
</body>
</html>