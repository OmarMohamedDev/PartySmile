<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title> PartySmile - Just have fun! - Pannello di amministrazione</title>
<link href="./CSS/sitestyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/administrationControl.js" charset="utf-8"></script>
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
  	<h1>Pannello di amministrazione</h1>
    <p class="info2">Pagina dove poter amministrare gli utenti e le funzionalità di PartySmile</p>
    <p class="info3" id="errorMessage"><?php echo($errorMessage); ?></p>
    
    <?php 
    require './php_resources/check_session.php';
	require './php_resources/dbConn.php';
	require './php_resources/function.php';
	
	$errorMessage="";
	$errorMessage2="";
	
	if($_SESSION["administrator"]==0) {
	?>
		<script type="text/javascript">
		location.replace("accessdenied.php")
		</script>
	<?php 
	}
	
	if(isset($_POST['uname'])){
		if($_SESSION['username'] != $_POST['uname']){
			
			?><script type="text/javascript">var flag= clientSideAdministrationControl('<?php echo $_POST['uname'] ?>');
    
    if(flag==true){<?php
		
		require './php_resources/administrationControl.php';
		
		if($flag==true){
			
			if(isset($_POST['promuoviUtente'])){
				dbConnect();
				$qry = "UPDATE `dbomarmohamed`.`utenti` SET `administrator` = 1  WHERE `utenti`.`username` = '".$_POST['uname']."'";
				$check = mysql_query($qry);
				mysql_close();
			}
			elseif(isset($_POST['degradaUtente'])){
				
				dbConnect();
				$qry = "SELECT superadministrator FROM utenti WHERE username = '".$_POST['uname']."'";
   				$check = mysql_query($qry);
   				$info = mysql_fetch_row($check);
				
				if($info[0]==1)
					$errorMessage2="[SERVER-SIDE CHECK] Impossibile degradare l'amministratore principale di PartySmile";
				else{
				
				$qry = "UPDATE `dbomarmohamed`.`utenti` SET `administrator` = 0  WHERE `utenti`.`username` = '".$_POST['uname']."'";
				$check = mysql_query($qry);
				mysql_close();
				}
			}

			
			elseif(isset($_POST['validaAccount'])){		
				dbConnect();
				$qry = "UPDATE `dbomarmohamed`.`utenti` SET `validated` = 1  WHERE `utenti`.`username` = '".$_POST['uname']."'";
				$check = mysql_query($qry);
				mysql_close();
			}
			
			elseif(isset($_POST['sospendiAccount'])){		
				
				dbConnect();
				$qry = "SELECT superadministrator FROM utenti WHERE username = '".$_POST['uname']."'";
   				$check = mysql_query($qry);
   				$info = mysql_fetch_row($check);
				
				if($info[0]==1)
					$errorMessage2="[SERVER-SIDE CHECK] Impossibile sospendere l'account dell'amministratore principale di PartySmile";
				else{
				
				$qry = "UPDATE `dbomarmohamed`.`utenti` SET `validated` = 0  WHERE `utenti`.`username` = '".$_POST['uname']."'";
				$check = mysql_query($qry);
				mysql_close();
				}
			}
			
			elseif(isset($_POST['eliminaUtente'])){	
				dbConnect();
				$qry = "SELECT superadministrator FROM utenti WHERE username = '".$_POST['uname']."'";
   				$check = mysql_query($qry);
   				$info = mysql_fetch_row($check);
				
				if($info[0]==1)
					$errorMessage2="[SERVER-SIDE CHECK] Impossibile eliminare l'amministratore principale di PartySmile";
				else{
				
				$qry = "SELECT avatarpath FROM utenti WHERE username = '".$_POST['uname']."'";
   				$check = mysql_query($qry);
   				$info = mysql_fetch_row($check);
				
				unlink ("".$info[0]."");
				
				$lista_file = caricaDirectory($_POST['uname']);
   				if (count($lista_file) > 0) {
					for ($i = 0; $i < count($lista_file); $i++) {
						unlink("./users/".$_POST['uname']."/pictures/big/preview_".$lista_file[$i]);
						unlink("./users/".$_POST['uname']."/pictures/small/small_".$lista_file[$i]);
					}
				}
				
				
				
				rmdir("./users/".$_POST['uname']."/avatar");
				rmdir("./users/".$_POST['uname']."/pictures/small");
				rmdir("./users/".$_POST['uname']."/pictures/big");
				rmdir("./users/".$_POST['uname']."/pictures");
				rmdir("./users/".$_POST['uname']);
				
				dbConnect();
				$qry = "DELETE FROM `dbomarmohamed`.`utenti` WHERE `utenti`.`username` = '".$_POST['uname']."'";
   				$check = mysql_query($qry);
				
				$qry = "DELETE FROM `dbomarmohamed`.`immagini` WHERE `immagini`.`username` = '".$_POST['uname']."'";
   				$check = mysql_query($qry);
				
				$qry = "DELETE FROM `dbomarmohamed`.`messaggistato` WHERE `messaggistato`.`username` = '".$_POST['uname']."'";
   				$check = mysql_query($qry);
				
				$qry = "DELETE FROM `dbomarmohamed`.`richiesteamicizia` WHERE `richiesteamicizia`.`sender` = '".$_POST['uname']."' OR `richiesteamicizia`.`receiver` = '".$_POST['uname']."'";
   				$check = mysql_query($qry);
				
				mysql_close();
				}
			}
		}	
?>}</script><?php	
		
	} else 
		$errorMessage2="[SERVER-SIDE CHECK] Impossibile promuovere, degradare, validare, sospendere o eliminare il proprio account. Richiedere la modifica ad un altro amministratore di PartySmile.";
}
		
?>
    
    <p class="info5" id="errorMessage2"><?php echo($errorMessage2); ?></p>
    <h3>Lista degli utenti iscritti</h3>
    <?php
    $lista_iscritti = loadUsers();
	$administrator="";
	$validated="";
  
              echo "<table>";
			  echo "<tr><td>Username</td><td>Amministratore</td><td>Utente Validato</td></tr>";
              for ($i = 0; $i < count($lista_iscritti); $i=$i+3) {
				  if($lista_iscritti[$i+1]==1)
				  	$administrator="si";
				  else 
				  	$administrator="no";
					
					if($lista_iscritti[$i+2]==1)
				  	$validated="si";
				  else 
				  	$validated="no";
					
                  echo "<tr><td>",$lista_iscritti[$i],"</td><td>",$administrator,"</td><td>",$validated,"</td></tr>";
              }       
         echo "</table>";
                            
	?>
    
  	<h3>Promuovi un utente ad amministratore</h3>
    
    <form class="form2" action="administrationpanel.php" method="post" >
        <p>Username <input class="field1" type="text"  name="uname" maxlength="15"><br>
        <input class="button2" type="submit"  name="promuoviUtente" value="Promuovi utente">
        <input type="submit"  name="degradaUtente" value="Degrada utente"></p>
    </form>
    
    <h3>Elimina un utente</h3> 
    
    <form class="form2" action="administrationpanel.php" method="post" >
        <p>Username <input class="field1" type="text" name="uname" maxlength="15"><br>
        <input class="button2" type="submit"  name="eliminaUtente" value="Elimina utente"></p>
    </form>
    
    <h3>Attiva l'account di un utente</h3>
    
    <form class="form2" action="administrationpanel.php" method="post" >
        <p>Username <input class="field1" type="text"  name="uname" maxlength="15"><br>
        <input class="button2" type="submit"  name="validaAccount" value="Valida account">
        <input type="submit"  name="sospendiAccount" value="Sospendi account" ></p>
    </form>

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
	  echo("<li class=\"selected\">Amministrazione sito</li>")?>
    </ul>
    <!-- end .sidebar2 --></div>
  <?php require("footer.php");?>
  <!-- end .container --></div>
</body>
</html>
