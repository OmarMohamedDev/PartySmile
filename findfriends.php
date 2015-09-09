<?php 
    require './php_resources/check_session.php';
	require './php_resources/dbConn.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title> PartySmile - Just have fun! - Cerca nuovi amici</title>
<link href="./CSS/sitestyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/findfriendsControl.js" charset="utf-8"></script>
</head>

<body>

<div class="container">
  <?php require("header.php"); ?>
  <div class="sidebar">
    <ul class="nav">
      <li><a href="home.php">Il tuo profilo</a></li>
      <li><a href="news.php">Notizie</a></li>
      <li class="selected"><a href="friends.php">Amici</a></li>
      <li><a href="pictures.php">Foto</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <!-- end .sidebar1 --></div>
  <div class="content">
  
  <?php 
  
  		if (isset($_GET['actualcity'])){
  
		$orderByName="<input class=\"button2\" type=\"button\"  name=\"orderByName\" value=\"Ordina per nome reale\" onclick=\"location.href='findfriends.php?actualcity=".$_GET['actualcity']."&amp;submit=Cerca&amp;orderBy=name';\">";
		
		$orderBySurname="<input class=\"button2\" type=\"button\"  name=\"orderByName\" value=\"Ordina per cognome reale\" onclick=\"location.href='findfriends.php?actualcity=".$_GET['actualcity']."&amp;submit=Cerca&amp;orderBy=surname';\">";
		
		$orderByDate="<input class=\"button2\" type=\"button\"  name=\"orderByName\" value=\"Ordina per data di nascita\" onclick=\"location.href='findfriends.php?actualcity=".$_GET['actualcity']."&amp;submit=Cerca&amp;orderBy=birthdate';\">";
		
		$orderByPlace="<input class=\"button2\" type=\"button\"  name=\"orderByName\" value=\"Ordina per città attuale\" onclick=\"location.href='findfriends.php?actualcity=".$_GET['actualcity']."&amp;submit=Cerca&amp;orderBy=actualcity';\">";
		
		}
		
		if (isset($_GET['name'])){
  
		$orderByName="<input class=\"button2\" type=\"button\"  name=\"orderByName\" value=\"Ordina per nome reale\" onclick=\"location.href='findfriends.php?name=".$_GET['name']."&amp;submit=Cerca&amp;orderBy=name';\">";
		
		$orderBySurname="<input class=\"button2\" type=\"button\"  name=\"orderByName\" value=\"Ordina per cognome reale\" onclick=\"location.href='findfriends.php?name=".$_GET['name']."&amp;submit=Cerca&amp;orderBy=surname';\">";
		
		$orderByDate="<input class=\"button2\" type=\"button\"  name=\"orderByName\" value=\"Ordina per data di nascita\" onclick=\"location.href='findfriends.php?name=".$_GET['name']."&amp;submit=Cerca&amp;orderBy=birthdate';\">";
		
		$orderByPlace="<input class=\"button2\" type=\"button\"  name=\"orderByName\" value=\"Ordina per città attuale\" onclick=\"location.href='findfriends.php?name=".$_GET['name']."&amp;submit=Cerca&amp;orderBy=actualcity';\">";
		
		}
		
		if (isset($_GET['surname'])){
  
		$orderByName="<input class=\"button2\" type=\"button\"  name=\"orderByName\" value=\"Ordina per nome reale\" onclick=\"location.href='findfriends.php?surname=".$_GET['surname']."&amp;submit=Cerca&amp;orderBy=name';\">";
		
		$orderBySurname="<input class=\"button2\" type=\"button\"  name=\"orderByName\" value=\"Ordina per cognome reale\" onclick=\"location.href='findfriends.php?surname=".$_GET['surname']."&amp;submit=Cerca&amp;orderBy=surname';\">";
		
		$orderByDate="<input class=\"button2\" type=\"button\"  name=\"orderByName\" value=\"Ordina per data di nascita\" onclick=\"location.href='findfriends.php?surname=".$_GET['surname']."&amp;submit=Cerca&amp;orderBy=birthdate';\">";
		
		$orderByPlace="<input class=\"button2\" type=\"button\"  name=\"orderByName\" value=\"Ordina per città attuale\" onclick=\"location.href='findfriends.php?surname=".$_GET['surname']."&amp;submit=Cerca&amp;orderBy=actualcity';\">";
		
		}
	
	 ?>
  <?php $errorMessage=""; ?>
  
    <h1>Cerca nuovi amici <?php if(isset($_GET['submit'])){ ?> </br> <?php echo $orderByName; echo $orderBySurname; echo $orderByDate; echo $orderByPlace; }?> </h1>
   <p class="info2">Cerca utenti che conosci tramite gli appositi campi di ricerca.</p>
    
    <p class="info3" id="errorMessage"><?php echo $errorMessage; ?></p>
    
    
       <?php
	dbConnect();
	
	if (isset($_GET['submit'])) { //se il form è stato inviato, si effettuano dei controlli dell'input sia client-side che server-side
	
		if (isset($_GET['uname'])) {
		?><script type="text/javascript">var flag= clientSideFindFriendsControlUsername('<?php echo $_GET['uname'] ?>');
    
    	if(flag==true){<?php

     require './php_resources/findfriendsControl.php';
	
	// se tutti i controlli vanno a buon fine, si effettua la ricerca richiesta dall'utente e si mostrano i risultati
		if($flag==true){
			
				$qry = "SELECT username, name, surname FROM utenti WHERE username = '".$_GET['uname']."'";
				$check = mysql_query($qry);
				$numberRows= mysql_num_rows($check);
				$friendFound="";
			
			} 
		?>}</script><?php }
		
		
		if (isset($_GET['email'])) {
		?><script type="text/javascript">var flag= clientSideFindFriendsControlEmail('<?php echo $_GET['email'] ?>');
    
    	if(flag==true){<?php

     require './php_resources/findfriendsControl.php';
	
	// se tutti i controlli vanno a buon fine, si effettua la ricerca richiesta dall'utente e si mostrano i risultati
		if($flag==true){
			
				$qry = "SELECT username, name, surname FROM utenti WHERE email = '".$_GET['email']."'";
				$check = mysql_query($qry);
				
				if(!$check)
					die(mysql_error());
				
				$numberRows= mysql_num_rows($check);
				$friendFound="";
			}
		?>}</script><?php }
			
			
			if (isset($_GET['actualcity'])) {
		?><script type="text/javascript">var flag= clientSideFindFriendsControlActualCity('<?php echo $_GET['actualcity'] ?>');
    
    	if(flag==true){<?php

     require './php_resources/findfriendsControl.php';
	
	// se tutti i controlli vanno a buon fine, si effettua la ricerca richiesta dall'utente e si mostrano i risultati
		if($flag==true){
			
				$qry = "SELECT username, name, surname FROM utenti WHERE actualcity = '".$_GET['actualcity']."'";
				$check = mysql_query($qry);
				$numberRows= mysql_num_rows($check);
				$friendFound="";
			
			} 
		?>}</script><?php }
			
			
			if (isset($_GET['name'])) {
				
		?><script type="text/javascript">var flag= clientSideFindFriendsControlName('<?php echo $_GET['name'] ?>');
    
    	if(flag==true){<?php

     require './php_resources/findfriendsControl.php';
	
	// se tutti i controlli vanno a buon fine, si effettua la ricerca richiesta dall'utente e si mostrano i risultati
		if($flag==true){
			
				$qry = "SELECT username, name, surname FROM utenti WHERE name = '".$_GET['name']."'";
				$check = mysql_query($qry);
				$numberRows= mysql_num_rows($check);
				$friendFound="";
		} 
		
		?>}</script><?php }
		
		if (isset($_GET['surname'])) {
				
		?><script type="text/javascript">var flag= clientSideFindFriendsControlSurname('<?php echo $_GET['surname'] ?>');
    
    	if(flag==true){<?php

     require './php_resources/findfriendsControl.php';
	
	// se tutti i controlli vanno a buon fine, si effettua la ricerca richiesta dall'utente e si mostrano i risultati
		if($flag==true){
			
				$qry = "SELECT username, name, surname FROM utenti WHERE surname = '".$_GET['surname']."'";
				$check = mysql_query($qry);
				$numberRows= mysql_num_rows($check);
				$friendFound="";
		} 
		
		?>}</script><?php }
		
		
			
			if (isset($_GET['orderBy'])){
				$qry=$qry." ORDER BY ".$_GET['orderBy'];
				$check= mysql_query($qry);
				
				if(!$check)
					die(mysql_error()."Non superato l'order by".$qry);
				
			}
			
			
			echo("<ul>");
				
				while($info = mysql_fetch_array($check)){
					
					$friendFound = $info['username'];
					
					 echo "<li><a href=\"userfriend.php?friend=",$friendFound,"\">",$friendFound,"</a> (".$info['name']." ".$info['surname'].")</li>";
				}
				echo("</ul");
				
				
	
	}
	
	?>
    
    <p></p>
   <p class="info5" id="errorMessage2"><?php echo $errorMessage2; ?></p>
    <p></p>
    <h3>Cerca amico per username</h3>
    
    <form class="form2" action="findfriends.php" method="GET" >
        <p>Username<br>
        <input class="field4" type="text"  name="uname" maxlength="15"><br>
        <input type="submit"  name="submit" value="Cerca"></p>
    </form>
    
    <h3>Cerca amico per nome</h3>
    
    <form class="form2" action="findfriends.php" method="GET" >
       <p>Nome<br> 
       <input class="field4" type="text" name="name" maxlength="15"><br>
        <input type="submit" name="submit" value="Cerca"></p>
    </form>
    
     <h3>Cerca amico per Cognome</h3>
    
    <form class="form2" action="findfriends.php" method="GET" >
      <p>Cognome<br>
       <input class="field4" type="text"  name="surname" maxlength="15"><br>
        <input type="submit"  name="submit" value="Cerca"></p>
    </form>
    
    <h3>Cerca amico per indirizzo email</h3>
    
    <form class="form2" action="findfriends.php" method="GET" >
        <p>Email<br> 
        <input class="field4" type="text"  name="email" maxlength="50"><br>
        <input type="submit"  name="submit" value="Cerca"></p>
    </form>
    
    <h3>Cerca amico per città in cui vive attualmente</h3>
    
    <form class="form2" action="findfriends.php" method="GET" >
     <p>Città attuale<br> 
        <input class="field4" type="text"  name="actualcity" maxlength="20"><br>
        <input type="submit"  name="submit" value="Cerca"></p>
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
	  echo("<li><a href=\"administrationpanel.php\">Amministrazione sito</a></li>")?>
    </ul>
    <!-- end .sidebar2 --></div>
  <?php require("footer.php");?>
  <!-- end .container --></div>
</body>
</html>
