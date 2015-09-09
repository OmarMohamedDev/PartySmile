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
<script type="text/javascript" src="js/commentsControl.js" charset="utf-8"></script>
<script type="text/javascript" src="js/statusControl.js" charset="utf-8"></script>
</head>

<body>

<div class="container">
  <?php require("header.php"); ?>
  <div class="sidebar">
    <ul class="nav">
      <li><a href="home.php">Il tuo profilo</a></li>
      <li class="selected">Notizie</li>
      <li><a href="friends.php">Amici</a></li>
      <li><a href="pictures.php">Foto</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <!-- end .sidebar1 --></div>
  <div class="content">
    <h1>Notizie</h1>
    <p class="info2">Questa pagina ti permette di leggere i tuoi messaggi di stato e quelli dei tuoi amici.</p>
    
    <h3 class="news">Messaggi di stato</h3>
    
    <p class="info3" id="errorMessage"><?php echo $errorMessage; ?></p>
    
    <?php
	dbConnect();
	
	if(isset($_GET['submitModifyComment'])){
		
		?><script type="text/javascript">var flag= clientSideCommentsControl('<?php echo $_GET['commentsText'] ?>');
    
    	if(flag==true){<?php

		require('./php_resources/commentsControl.php');
			
			if($flag==true){
				
				$sql1 = "SELECT comments FROM messaggistato WHERE id = '".$_GET['modifyComment']."'";
					$result= mysql_query($sql1);
					$oldComment = mysql_fetch_row($result);
					$divideString = explode(':',$_GET['commentMessage'],-1);
			$oldComment[0]=preg_replace("/".$_GET['commentMessage']."#/",$divideString[0].":".$_GET['commentsText']."#",$oldComment[0],1);
				
			$sql = "UPDATE `dbomarmohamed`.`messaggistato` SET `comments` = '".$oldComment[0]."' WHERE `messaggistato`.`id` = ".$_GET['modifyComment'].";";
				$result = mysql_query($sql);
				
				
			}
			
			?>}</script><?php
		}
		
		if(isset($_GET['deleteComment'])){
			
			$sql1 = "SELECT comments FROM messaggistato WHERE id = '".$_GET['deleteComment']."'";
					$result= mysql_query($sql1);
					$oldComment = mysql_fetch_row($result);
			$oldComment[0]=preg_replace("/".$_GET['commentMessage']."#/","",$oldComment[0],1);
				
			$sql = "UPDATE `dbomarmohamed`.`messaggistato` SET `comments` = '".$oldComment[0]."' WHERE `messaggistato`.`id` = ".$_GET['deleteComment'].";";
				$result = mysql_query($sql);
				
		}
	
	if(isset($_POST['submitModifyStatus'])){
		
		?><script type="text/javascript">var flag= clientSideStatusControl('<?php echo $_POST['newStatusMessage'] ?>');
    
    	if(flag==true){<?php
			
		require('./php_resources/statusControl.php');
			
			if($flag==true){
				
				$sql = "UPDATE `dbomarmohamed`.`messaggistato` SET `statusmessage` = '".$_POST['newStatusMessage']."' WHERE `messaggistato`.`id` = ".$_POST['modifyStatus'].";";
				$result = mysql_query($sql);
				
				
			}
			
			?>}</script><?php
		}
		
		if(isset($_GET['deleteStatus'])){
				
			$qry = "DELETE FROM `dbomarmohamed`.`messaggistato` WHERE `messaggistato`.`id` = '".$_GET['deleteStatus']."'";
   				$check = mysql_query($qry);	
				
		}
	
	
	if(isset($_GET['saveComment'])){
		
		?><script type="text/javascript">var flag= clientSideCommentsControl('<?php echo $_GET['commentsText'] ?>');
    
    	if(flag==true){<?php
			
			require('./php_resources/commentsControl.php');
			     
			if($flag==true){ 
				 dbConnect();
         
					$sql1 = "SELECT comments FROM messaggistato WHERE id = '".$_GET['id']."'";
					$result= mysql_query($sql1);
					$oldComment = mysql_fetch_row($result);
					
					$sql2 = "UPDATE messaggistato SET comments = '".$oldComment[0]."".$_GET['commentsUsername'].":".$_GET['commentsText']."#' WHERE id = '".$_GET['id']."'";
					mysql_query($sql2);
				
			
			}
			
			?>}</script><?php
			
		}
	?>	
    
	<p class="info5" id="errorMessage2"><?php echo $errorMessage2; ?></p>
    
	<?php
	dbConnect();
	$qry = "SELECT sender FROM richiesteamicizia WHERE (sender = '".$_SESSION['username']."' OR receiver = '".$_SESSION['username']."') AND state = 2;";
	$check=mysql_query($qry);
	$info=mysql_fetch_row($check);
	 
	if(count($info)<=0 | $info==false)
	$qry = "SELECT * FROM messaggistato WHERE username = '".$_SESSION['username']."' ORDER BY id DESC";
	else
	$qry = "SELECT `messaggistato`.`id`,`messaggistato`.`username`,`messaggistato`.`statusmessage`,`messaggistato`.`comments` FROM messaggistato INNER JOIN richiesteamicizia on (messaggistato.username = richiesteamicizia.sender) or (messaggistato.username = richiesteamicizia.receiver) WHERE  `richiesteamicizia`.`state` = 2 AND ((`richiesteamicizia`.`sender`='".$_SESSION['username']."') OR (`richiesteamicizia`.`receiver`='".$_SESSION['username']."')) GROUP BY `messaggistato`.`statusmessage`  ORDER BY id DESC";
		$check = mysql_query($qry);
		
		if(!$check)
		die(mysql_error());
		
		$numberRows= mysql_num_rows($check);
	
	if($numberRows>0){
	
	while($info = mysql_fetch_array($check)){
		?><div class="status"> <?php
		 echo "<p><b>",$info['username'],":</b> ",$info['statusmessage'],"</p>";
		 if($info['username']==$_SESSION['username'] | $_SESSION['administrator']==1){
		 		 echo "<h4 class=\"info\">Manipola messaggio di stato</h4>";
		 echo "<form class=\"form\" action=\"news.php\" method=\"POST\"><p><input type=\"text\" name=\"newStatusMessage\" ><input type=\"hidden\" name=\"modifyStatus\" value=\"".$info['id']."\"><input type=\"submit\" name=\"submitModifyStatus\" value=\"Modifica\" onclick=\"return clientSideStatusControl(this.form);\">";
		 echo "<input type=\"button\"  name=\"deleteStatus\" value=\"Elimina messaggio\" onclick=\"location.href='news.php?deleteStatus=".$info['id']."';\"></p></form>";
		 }
		 echo "<hr class=\"divide\">";
		 echo "<h4 class=\"info\">Inserisci un commento</h4>";
		 echo "<form class=\"form\" action=\"news.php\"  method=\"get\"><p><input type=\"text\" name=\"commentsText\" ><input type=\"hidden\" name=\"commentsUsername\" value=\"".$_SESSION['username']."\"><input type=\"hidden\" name=\"id\" value=\"".$info['id']."\"><input type=\"submit\" name=\"saveComment\" value=\"Inserisci commento\" onclick=\"return clientSideCommentsControl(this.form);\"><input type=\"reset\" value=\"Cancella\"></p></form>";
		 echo "<hr class=\"divide\">";
		 echo "<h4 class=\"info\">Commenti inseriti in precedenza</h4>";

		
		$commentsArray = explode('#',$info['comments'],-1);
		
		for($i=0;$i<count($commentsArray);$i++){
			echo "<p>";
			echo "".$commentsArray[$i]."<br>"; 
			$divideString = explode(':',$commentsArray[$i],-1);
			if($divideString[0]==$_SESSION['username'] | $_SESSION['administrator']==1){
			echo "<form class=\"form\" action=\"news.php\" method=\"get\"><p><input type=\"text\" name=\"commentsText\" ><input type=\"hidden\" name=\"modifyComment\" value=\"".$info['id']."\"><input type=\"hidden\" name=\"commentMessage\" value=\"".$commentsArray[$i]."\"><input type=\"submit\" name=\"submitModifyComment\" value=\"Modifica\" onclick=\"return clientSideCommentsControl(this.form);\">";
		 echo "<input type=\"button\"  name=\"deleteComment\" value=\"Elimina commento\" onclick=\"location.href='news.php?deleteComment=".$info['id']."&amp;commentMessage=".$commentsArray[$i]."';\"></p></form>";
			}
		 echo "<hr class=\"divide\">";
		 echo "</p>";
		}
		
		
		?></div>
    <?php
	}
	}
	
else
	echo("<p class=\"info2\">Nessun utente di PartySmile ha ancora scritto un messaggio di stato.</p>");
	
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