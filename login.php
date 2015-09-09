<?php

require './php_resources/dbConn.php';
	if ($dbFlag==false) {
		header("location: firstconnection.php");
	}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>PartySmile - Just have fun! - Login</title>
<link href="./CSS/sitestyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/loginControl.js" charset="utf-8"></script>
</head>

<body>
<!-- Struttura HTML del form di login-->

<div class="container">
  <?php require("header.php"); ?>
  <div class="content">
    <h1>Login</h1>
    <p class="info2">Inserisci username e password che hai immesso in fase di registrazione per effettuare il login.</p>
	<p class="info3" id="errorMessage"><?php echo($errorMessage); ?></p>
    
    <?php
session_start();
//Pagina dove gli utenti possono effettuare il login
if(isset($_SESSION["logged_in"])) 
header("location: justloggedin.php");
$errorMessage="";

if (isset($_POST['submit'])) { //se il form è stato inviato, si effettuano dei controlli dell'input sia client-side che server-side

?><script type="text/javascript">var flag= clientSideLoginControl('<?php echo $_POST['uname'] ?>','<?php echo $_POST['passwd'] ?>');
    
    	if(flag==true){<?php

     require './php_resources/loginControl.php';
	
	// se tutti i controlli vanno a buon fine, si registrano i dati in delle variabili di sessione e si accede al sito
	if($flag==true){
		
	$qry = "SELECT email, administrator, validated, name, surname, birthdate, birthcity, actualcity, sentimentalsituation, avatarpath FROM utenti WHERE username = '".$_POST['uname']."'";
    $check = mysql_query($qry);
    $info = mysql_fetch_row($check);
 
    $_SESSION['username'] = $_POST['uname'];
    $_SESSION['password'] = $_POST['passwd'];
	$_SESSION["email"] = stripslashes($info[0]);
	$_SESSION["administrator"] = stripslashes($info[1]);
	$_SESSION["validated"] = stripslashes($info[2]);
	$_SESSION["name"] = stripslashes($info[3]);   
	$_SESSION["surname"] = stripslashes($info[4]);
	$_SESSION["birthdate"] = stripslashes($info[5]);
	$_SESSION["birthcity"] = stripslashes($info[6]);
	$_SESSION["actualcity"] = stripslashes($info[7]);
	$_SESSION["sentimentalsituation"] = stripslashes($info[8]);
	$_SESSION["avatarpath"] = stripslashes($info[9]);
	
	$_SESSION["logged_in"] = 1;
    
	header("location: home.php");

}
?>}</script><?php
}    

?>

    <p class="info5" id="errorMessage2"><?php echo($errorMessage2); ?></p>
      <form class="form" action="login.php" method="post" >
	  <p>Username: <input class="field1" type="text"  name="uname" maxlength="15"><br>
      Password: <input class="field3" type="password"  name="passwd" maxlength="15"><br>
      <input class="button" type="submit"  name="submit" value="Login"  onclick="return clientSideLoginControl(this.form);">
      <input type="reset" name="reset" value="Reset"></p>
    </form>

<p class="info2">ATTENZIONE: Se il vostro account non è ancora stato validato da un amministratore, non sarà possibile accedere ad alcuna delle aree private del sito.</p>
<p class="info">(<a href="registration.php">Non sei ancora registrato?</a>)</p>
    <!-- end .content --></div>
  <?php require("footer.php");?>
  <!-- end .container --></div>

</body>
</html>