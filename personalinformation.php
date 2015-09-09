<?php 
    require './php_resources/check_session.php';
	require './php_resources/dbConn.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title> PartySmile - Just have fun! - Pannello di controllo utente</title>
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
    <h1>Informazioni personali</h1>
    <p><img alt="image" src=" <?php echo $_SESSION['avatarpath'] ?>"><br>
    Username: <?php echo $_SESSION['username']?> <br>
    Password: <?php echo $_SESSION['password']?> <br>
    Email: <?php echo $_SESSION['email']?> <br>
    Nome: <?php echo $_SESSION['name']?> <br>
    Cognome: <?php echo $_SESSION['surname']?> <br>
    Data di nascita: <?php echo date("d-m-Y", strtotime($_SESSION['birthdate']))?> <br>
    Città di nascita: <?php echo $_SESSION['birthcity']?> <br>
    Città attuale: <?php echo $_SESSION['actualcity']?> <br>
    Situazione sentimentale: <?php echo $_SESSION['sentimentalsituation']?></p>
    
    <p class="info">(<a href="controlpanel.php">Modifica i tuoi dati personali</a>)</p>
    <!-- end .content --></div>
  <div class="sidebar">
  <ul class="nav">
      <li class="selected">Informazioni personali</li>
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
