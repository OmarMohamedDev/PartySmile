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
<script type="text/javascript" src="js/informationControl.js" charset="utf-8"></script>
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
   
   <h1>Pannello di controllo</h1>
   <h3>Cambia immagine del profilo</h3>
   <p class="info2">Carica dai tuoi file locali l'immagine che desidi inserire come avatar del tuo profilo.</p>
   <p class="info3" id="errorMessage2"><?php echo $errorMessage2; ?></p>
   <form class="form2" action="controlpanel.php" method="post" enctype="multipart/form-data">
            <p>File da caricare:<br>
            <input type="file" name="nomefile"><br>
            <input type="submit" name="invia" value="Invia"></p>
        </form>
    <h3>Modifica i tuoi dati personali</h3>
    <p class="info2">Puoi modificare i dati che hai inserito in fase di registrazione e/o completare il tuo profilo con informazioni aggiuntive. Per politiche di gestione interne non è possibile modificare la propria username.</p>
	<p class="info3" id="errorMessage"><?php echo $errorMessage; ?></p>
    
    
        <?php
//Pagina dove gli utenti possono modificare i loro dati personali
dbConnect();
$errorMessage="";
$errorMessage2="";


if (isset($_FILES["nomefile"])) 
     require './php_resources/loadAvatar.php';

if (isset($_POST['submit'])) { //se il form è stato inviato, si effettuano dei controlli dell'input sia client-side che server-side

	?><script type="text/javascript">var flag= clientSideInformationControl('<?php echo $_POST['passwd'] ?>','<?php echo $_POST['email'] ?>','<?php echo $_POST['name'] ?>','<?php echo $_POST['surname'] ?>','<?php echo $_POST['birthdate'] ?>','<?php echo $_POST['birthcity'] ?>','<?php echo $_POST['actualcity'] ?>','<?php echo $_POST['sentimentalsituation'] ?>');
    
    if(flag==true){<?php
	
     require './php_resources/informationControl.php';
	
	if($flag==true){ // se tutti i controlli vanno a buon fine, si registrano i dati dell'utente
 
    $_SESSION['password'] = $_POST['passwd'];
	$_SESSION["email"] = $_POST['email'];
	$_SESSION["name"] = $_POST['name'];
	$_SESSION["surname"] = $_POST['surname'];
	$_SESSION["birthdate"] = date("Y-m-d", strtotime($_POST['birthdate']));
	$_SESSION["birthcity"] = $_POST['birthcity'];
	$_SESSION["actualcity"] = $_POST['actualcity'];
	$_SESSION["sentimentalsituation"] = $_POST['sentimentalsituation'];
	
	$_POST['passwd'] = md5($_POST['passwd']);
	$_POST['passwd'] = addslashes($_POST['passwd']);
	$_POST["email"] = addslashes($_POST['email']);
	$_POST["name"] = addslashes($_POST['name']);
	$_POST["surname"] = addslashes($_POST['surname']);
	$_POST["birthdate"] = date("Y-m-d", strtotime($_POST['birthdate']));
	$_POST["birthdate"] = addslashes($_POST['birthdate']);
	$_POST["birthcity"] = addslashes($_POST['birthcity']);
	$_POST["actualcity"] = addslashes($_POST['actualcity']);
	$_POST["sentimentalsituation"] = addslashes($_POST['sentimentalsituation']);
		
		
		$qry = "UPDATE `dbomarmohamed`.`utenti` SET `password` = '".$_POST['passwd']."', `email` = '".$_POST['email']."', `name` = '".$_POST['name']."' , `surname` = '".$_POST['surname']."', `birthdate` = '".$_POST['birthdate']."', `birthcity` = '".$_POST['birthcity']."', `actualcity` = '".$_POST['actualcity']."', `sentimentalsituation` = '".$_POST['sentimentalsituation']."' WHERE `utenti`.`username` = '".$_SESSION['username']."'";
    $check = mysql_query($qry);
	
	mysql_close($db);
    
header("location: personalinformation.php");
	
	}?>}</script><?php }    

?>
    
    
    
    <p class="info5" id="errorMessage3"><?php echo $errorMessage3; ?></p>
    
    <form class="form2" action="controlpanel.php" method="post" >
      <p>Password<br>
	  <input class="field4" type="text" name="passwd" maxlength="15" value="<?php echo $_SESSION['password'] ?>"><br>
      Email<br>
      <input class="field4" type="text" name="email" maxlength="50" value="<?php echo $_SESSION['email'] ?>"><br>
      Nome<br>
      <input class="field4" type="text"  name="name" maxlength="15" value="<?php echo $_SESSION['name'] ?>"><br>
      Cognome<br>
      <input class="field4" type="text"  name="surname" maxlength="15" value="<?php echo $_SESSION['surname'] ?>"><br>
      Data di nascita (GG-MM-AAAA)<br>
      <input class="field4" type="text"  name="birthdate" value="<?php echo date("d-m-Y", strtotime($_SESSION['birthdate'])) ?>"><br>
      Città di nascita<br>
      <input class="field4" type="text"  name="birthcity" maxlength="20" value="<?php echo $_SESSION['birthcity'] ?>"><br>
      Città attuale<br>
      <input class="field4" type="text"  name="actualcity" maxlength="20" value="<?php echo $_SESSION['actualcity'] ?>"><br>
      Situazione sentimentale<br>
      <input class="field4" type="text"  name="sentimentalsituation" maxlength="30" value="<?php echo $_SESSION['sentimentalsituation'] ?>"><br>
      <input class="button2" type="submit"  name="submit" value="Salva modifiche">
      <input type="reset" name="reset" value="Cancella modifiche"></p>
    </form>
   
   
    <!-- end .content --></div>
  <div class="sidebar">
  <ul class="nav">
      <li class="selected"><a href="personalinformation.php">Informazioni personali</a></li>
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
