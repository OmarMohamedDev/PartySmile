<?php
require './php_resources/dbConn.php';
	if ($dbFlag==true) {
		header("location: accessdenied.php");
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>PartySmile - Just have fun! - Prima connessione al sito</title>
<link href="./CSS/sitestyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/firstConnectionControl.js" charset="utf-8"></script>
</head>

<body>

<div class="container">
  <?php require("header.php"); ?>
  <div class="content">
    <h1>Prima connessione a PartySmile</h1>
    <p class="info2">Questa è la prima volta che si accede al Social Network PartySmile.<br>Inserisci nome, password, nome host e nome db per creare la connessione al database.</p>
    <p class="info3" id="errorMessage"><?php echo($errorMessage); ?></p>
    
  <?php if (isset($_POST['submit'])) { //se il form è stato inviato, si effettuano dei controlli dell'input sia client-side che server-side

?><script type="text/javascript">var flag= clientSideFirstConnectionControl('<?php echo $_POST['username'] ?>','<?php echo $_POST['password'] ?>','<?php echo 'ftp.creativesolutions.altervista.org:21' ?>','<?php echo 'my_creativesolutions' ?>');
    
    	if(flag==true){<?php

     require './php_resources/firstConnectionControl.php';
	
	// se tutti i controlli vanno a buon fine, si registrano i dati in delle variabili di sessione e si accede al sito
			if($flag==true){ 
			
			$filename = './php_resources/dbConn.php';
			$string = "<?php
			
			\$dbFlag=true;

// Funzione che permette la connessione al database my_partysmile
function dbConnect(){
\$db= mysql_connect(\'localhost\',\'partysmile\',\'\')
        or die (\"Connessione non riuscita: \" . mysql_error());

mysql_select_db(\"my_partysmile", \$db)
        or die (\"Selezione del database non riuscita\"); 

}
?>";

			$fp = fopen($filename, 'w');
			fwrite($fp, $string);
			fclose($fp);
			
			$qry1="CREATE TABLE IF NOT EXISTS `immagini` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `src` text NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ";

			$qry2="CREATE TABLE IF NOT EXISTS `messaggistato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `statusmessage` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;";
			
			$qry3="CREATE TABLE IF NOT EXISTS `richiesteamicizia` (
  `sender` varchar(15) NOT NULL,
  `receiver` varchar(15) NOT NULL,
  `state` tinyint(1) NOT NULL,
  KEY `sender` (`sender`),
  KEY `receiver` (`receiver`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			
			$qry4="CREATE TABLE IF NOT EXISTS `utenti` (
  `username` varchar(15) NOT NULL,
  `password` char(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `administrator` tinyint(1) NOT NULL DEFAULT '0',
  `superadministrator` tinyint(1) NOT NULL DEFAULT '0',
  `validated` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(15) NOT NULL,
  `surname` varchar(15) NOT NULL,
  `birthdate` date NOT NULL DEFAULT '1970-01-01',
  `birthcity` varchar(20) NOT NULL,
  `actualcity` varchar(20) NOT NULL,
  `sentimentalsituation` varchar(30) NOT NULL,
  `avatarpath` varchar(100) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$qry5="SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\""; 
			
			$check1 = mysql_query($qry5);
			if(!$check1)
			die(mysql_error());
			
   		    $check2 = mysql_query($qry1);
			if(!$check2)
			die(mysql_error());
			
			$check3 = mysql_query($qry2);
			if(!$check3)
			die(mysql_error());
			
			$check4 = mysql_query($qry3);
			if(!$check4)
			die(mysql_error());
			
			$check5 = mysql_query($qry4);
			if(!$check5)
			die(mysql_error());
			
	//creazione del primo utente a cui vengono assegnati in automatico i permessi da utente validato, amministratore e superamministratore 

	mkdir("./users/".$_POST['username'], 0777);
	mkdir("./users/".$_POST['username']."/pictures", 0777);
	mkdir("./users/".$_POST['username']."/pictures/big", 0777);
	mkdir("./users/".$_POST['username