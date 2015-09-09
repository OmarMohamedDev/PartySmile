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
<title>PartySmile - Just have fun! - Registrazione</title>
<link href="./CSS/sitestyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/registrationControl.js" charset="utf-8"></script>
<!--Richiamo gli script del file registrationControl.js presente nella 
cartella js all'interno della pagina php -->
</head>

<body>

<div class="container">
  <?php require("header.php"); ?>
  <div class="content">
    <h1>Registrazione nuovo utente</h1>
    <p class="info2">La compilazione di tutti i campi è obbligatoria.<br>
    Username e password devono avere una lunghezza compresa tra 5 e 15 caratteri.<br>
    Non è possibile usare i seguenti caratteri: | , + , - , -- , = , < , > , ! , != , ( , ) , % , *,'</p>
    <p class="info3" id="errorMessage"><?php echo($errorMessage); ?></p>
    
    <?php 
//Pagina dove gli utenti possono effettuare la registrazione al sito
$errorMessage="";

if (isset($_POST['submit'])) { //se il form di registrazione è stato inviato, si controlla che tutti i campi siano stati compilati

?><script type="text/javascript">var flag= clientSideRegistrationControl('<?php echo $_POST['uname'] ?>','<?php echo $_POST['passwd'] ?>','<?php echo $_POST['email'] ?>');
    
    	if(flag==true){<?php

    require './php_resources/registrationControl.php';  
	 
	 // se tutti i controlli vanno a buon fine, si accede al database e si registrano i dati immessi dall'utente
	
	if($flag==true){
		
	mkdir("./users/".$_POST['uname'], 0777);
	mkdir("./users/".$_POST['uname']."/pictures", 0777);
	mkdir("./users/".$_POST['uname']."/pictures/big", 0777);
	mkdir("./users/".$_POST['uname']."/pictures/small", 0777);
	mkdir("./users/".$_POST['uname']."/avatar", 0777);
	
	require './php_resources/createDefaultAvatar.php';  
		 
	$_POST['uname'] = addslashes($_POST['uname']);
	$_POST['passwd'] = md5($_POST['passwd']);
	$_POST['passwd'] = addslashes($_POST['passwd']);
	$_POST['email'] = addslashes($_POST['email']);
	$avatarpath = addslashes("./users/".$_POST['uname']."/avatar/".$_POST['uname']."Avatar.jpg");
	
	
	$qry = "INSERT INTO `my_partysmile`.`utenti` (`username`, `password`, `email`,`avatarpath`) VALUES ('".$_POST['uname']."', '".$_POST['passwd']."', '".$_POST['email']."' , '".$avatarpath."')";
    $check = mysql_query($qry);	
	
header("location: waitingvalidation.php");

}

?>}</script><?php

}  

?>
    <p class="info5" id="errorMessage2"><?php echo($errorMessage2); ?></p>
    <form class="form" action="registration.php" method="post" >
     <p>Username: <input class="field1" type="text"  name="uname" maxlength="15"><br>
       	Password: <input class="field3" type="password" name="passwd" maxlength="15"><br>
        Email: <input class="field2" type="text" name="email" maxlength="50"><br>
        <input class="button" type="submit" name="submit" value="Registrati" onclick="return clientSideRegistrationControl(this.form);">
        <input type="reset" name="reset" value="Reset"></p>
    </form>
    <p class="info">(<a href="login.php">Sei già registrato?</a>)</p>
    <!-- end .content --></div>
  <?php require("footer.php");?>
  <!-- end .container --></div>
  
</body>
</html>