<?php 
    require './php_resources/check_session.php';
	require './php_resources/checkUserFriend.php';
	require './php_resources/dbConn.php';
    require_once("./php_resources/configFriend.php");
    require_once("./php_resources/function.php");
	
	if(isset($_GET['submitModifyStatusComment'])){
			
		?><script type="text/javascript">var flag= clientSideCommentsControl('<?php echo $_GET['commentsText'] ?>');
    
    	if(flag==true){<?php

		require('./php_resources/commentsControl.php');
			
			if($flag==true){
				dbConnect();
				$sql1 = "SELECT comments FROM messaggistato WHERE id = '".$_GET['modifyComment']."'";
					$result= mysql_query($sql1);
					$oldComment = mysql_fetch_row($result);
					$divideString = explode(':',$_GET['commentMessage'],-1);
			$oldComment[0]=preg_replace("/".$_GET['commentMessage']."#/",$divideString[0].":".$_GET['commentsText']."#",$oldComment[0],1);
				
			$sql = "UPDATE `dbomarmohamed`.`messaggistato` SET `comments` = '".$oldComment[0]."' WHERE `messaggistato`.`id` = ".$_GET['modifyComment'].";";
				$result = mysql_query($sql);
				mysql_close();
				
				
			}
			?>}</script><?php
		}
		
		if(isset($_GET['deleteStatusComment'])){
			dbConnect();
			$sql1 = "SELECT comments FROM messaggistato WHERE id = '".$_GET['deleteStatusComment']."'";
					$result= mysql_query($sql1);
					$oldComment = mysql_fetch_row($result);
			$oldComment[0]=preg_replace("/".$_GET['commentMessage']."#/","",$oldComment[0],1);
				
			$sql = "UPDATE `dbomarmohamed`.`messaggistato` SET `comments` = '".$oldComment[0]."' WHERE `messaggistato`.`id` = ".$_GET['deleteStatusComment'].";";
				$result = mysql_query($sql);
				mysql_close();
				
		}
	
	
	if(isset($_GET['submitModifyComment'])){

		require('./php_resources/commentsControl.php');
			
			if($flag==true){
				
				dbConnect();
				$sql1 = "SELECT comments FROM immagini WHERE src = '".$_GET['modifyComment']."'";
					$result= mysql_query($sql1);
					
					$oldComment = mysql_fetch_row($result);
					$divideString = explode(':',$_GET['commentMessage'],-1);
			$oldComment[0]=preg_replace("/".$_GET['commentMessage']."#/",$divideString[0].":".$_GET['commentsText']."#",$oldComment[0],1);
				
			$sql = "UPDATE `dbomarmohamed`.`immagini` SET `comments` = '".$oldComment[0]."' WHERE `immagini`.`src` = '".$_GET['modifyComment']."';";
				$result = mysql_query($sql);
				
				mysql_close();
				
				
				
				
			}
		}
		
		if(isset($_GET['deleteComment'])){
			
			dbConnect();
			$sql1 = "SELECT comments FROM immagini WHERE src = '".$_GET['deleteComment']."'";
					$result= mysql_query($sql1);
					
					$oldComment = mysql_fetch_row($result);
			$oldComment[0]=preg_replace("/".$_GET['commentMessage']."#/","",$oldComment[0],1);
				
			$sql = "UPDATE `dbomarmohamed`.`immagini` SET `comments` = '".$oldComment[0]."' WHERE `immagini`.`src` = '".$_GET['deleteComment']."';";
				$result = mysql_query($sql);
				
				mysql_close();
				
				header("Location: userfriend.php?friend=".$_GET['friend']."&index=".$_GET['index']."&src=".$_GET['src']);
				
		} 
	
	require_once("./php_resources/gallery.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>PartySmile - Just have fun! - I tuoi amici</title>
<link href="./CSS/sitestyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/commentsControl.js" charset="utf-8"></script>
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
  <div class="content" id="content"> 
  <?php
  
  if(isset($_GET['deleteImage'])){
 
           dbConnect();
		   
		   $qry = "DELETE FROM `dbomarmohamed`.`immagini` WHERE `src` = '".$_GET ['deleteImage']."'";
   				$check = mysql_query($qry);
			mysql_close();
			
			unlink (DIR_IMMAGINI_GRANDI."/preview_".$_GET['deleteImage']);
			unlink (DIR_IMMAGINI_PICCOLE . "/small_".$_GET['deleteImage']);

	}
  
  if(isset($_GET['saveComment'])){
			
			require('./php_resources/commentsControl.php');
			     
			if($flag==true){ 
				 dbConnect();
         
					$sql1 = "SELECT comments FROM messaggistato WHERE id = '".$_GET['id']."'";
					$result= mysql_query($sql1);
					
					$oldComment = mysql_fetch_row($result);
					
					$sql2 = "UPDATE messaggistato SET comments = '".$oldComment[0]."".$_GET['commentsUsername'].":".$_GET['commentsText']."#' WHERE id = '".$_GET['id']."'";
					mysql_query($sql2);
					
					?><script type="text/javascript"> 
            location.replace("./userfriend.php?friend=<?php echo $_GET['friend'] ?>");
            </script> <?php
				
			
			}
			
		}
  
  if(isset($_GET['newComment'])){
				
				$lista_file = caricaDirectory($username); 
		 
		 require "./php_resources/commentsControl.php";
		 
		 if($flag==true){
         
     		dbConnect();
             $sql1 = "SELECT comments FROM immagini WHERE src = '".$lista_file[$_GET['index']]."'";
					$result= mysql_query($sql1);
					$oldComment = mysql_fetch_row($result);
					
					$sql2 = "UPDATE immagini SET comments = '".$oldComment[0]."".$_SESSION['username'].":".$_GET['commentsText']."#' WHERE src = '".$lista_file[$_GET['index']]."'";
					mysql_query($sql2);  
					mysql_close();
		 }
		 
		 ?><script type="text/javascript"> 
            location.replace("./userfriend.php?friend=<?php echo $username ?>&index=<?php echo $_GET['index'] ?>&src=<?php echo $_GET['src'] ?>");
            </script> <?php
            
     }
      
	 $friend = str_replace('"', "",$_GET['friend']); 
     $sendRequest="";
	 
	 if(isset($_GET['index'])){
         $actualImageIndex=$_GET['index'];
         $actualSrc=$_GET['src'];
         
         ?> <script type="text/javascript">openGallery('<?php echo $actualSrc ?>',<?php echo $actualImageIndex ?>);</script> <?php
     }
	 
		
				dbConnect();
				 
				if(isset($_GET['request'])){ 
					if($_GET['request']==1){
						
				$qry = "INSERT INTO `dbomarmohamed`.`richiesteamicizia` (`sender`, `receiver`, `state`) VALUES('".$_SESSION['username']."','".$friend."','".$_GET['request']."')"; 
				$check = mysql_query($qry);
					
					}
					else if($_GET['request']==0){
							
							$qry = "DELETE FROM `dbomarmohamed`.`richiesteamicizia` WHERE (`richiesteamicizia`.`sender` = '".$_SESSION['username']."' AND`richiesteamicizia`.`receiver` = '".$friend."') OR  (`richiesteamicizia`.`receiver` = '".$_SESSION['username']."' AND`richiesteamicizia`.`sender` = '".$friend."')";
							$check = mysql_query($qry);
							
					}
				} 
				
		  $qry = "SELECT sender,receiver,state FROM richiesteamicizia WHERE (sender = '".$_SESSION['username']."' OR receiver = '".$_SESSION['username']."') AND (sender = '".$friend."' OR receiver = '".$friend."')";
		  $check = mysql_query($qry);
		  $info = mysql_fetch_row($check);
			
		  if($info[2] == NULL | $info[2] == 0)
		$sendRequest="<input class=\"button2\" type=\"button\"  name=\"sendFriendRequest\" value=\"Invia richiesta di amicizia\" onclick=\"location.href='userfriend.php?friend=".$friend."&amp;request=1';\">";
		
		     
		  if($info[2] == 1)
		$sendRequest="<input class=\"button2\" type=\"button\"  name=\"deleteFriendRequest\" value=\"Annulla richiesta di amicizia\" onclick=\"location.href='userfriend.php?friend=".$friend."&amp;request=0';\">";
		  
		  
		  if($info[2] == 2)
		$sendRequest="<input class=\"button2\" type=\"button\"  name=\"deleteFriend\" value=\"Rimuovi dagli amici\" onclick=\"location.href='userfriend.php?friend=".$friend."&amp;request=0';\">";
	
	 ?>
     
    <h1>Profilo di <?php echo $friend; echo $sendRequest;?></h1>
    
    <?php 
	
	if($info[2]== 2){ 
	
	$qry = "SELECT * FROM utenti WHERE username = '".$_GET['friend']."'";
		  $check = mysql_query($qry);
		  $info = mysql_fetch_array($check);
	
	?>
		
        <h3>Informazioni personali</h3>
        <p><img alt="avatar" src=" <?php echo $info['avatarpath'] ?>"><br>
        Username: <?php echo $info['username']?> <br>
        Email: <?php echo $info['email']?> <br>
        Nome: <?php echo $info['name']?> <br>
        Cognome: <?php echo $info['surname']?> <br>
        Data di nascita: <?php echo date("d-m-Y", strtotime($info['birthdate']))?> <br>
        Città di nascita: <?php echo $info['birthcity']?> <br>
        Città attuale: <?php echo $info['actualcity']?> <br>
        Situazione sentimentale: <?php echo $info['sentimentalsituation']?></p>
		
        <h3>Messaggi di stato</h3>
<?php        


        $qry = "SELECT * FROM messaggistato WHERE username = '".$info['username']."' ORDER BY id DESC";
		$check = mysql_query($qry);
		$numberRows= mysql_num_rows($check);
	
	if($numberRows>0){
	
	while($info = mysql_fetch_array($check)){
		?><div class="status"> <?php
		 echo "<p><b>",$info['username'],":</b> ",$info['statusmessage'],"</p>";
		 echo "<form class=\"form\" action=\"userfriend.php\"  method=\"get\"><p><input type=\"text\" name=\"commentsText\" ><input type=\"hidden\" name=\"commentsUsername\" value=\"".$_SESSION['username']."\"><input type=\"hidden\" name=\"id\" value=\"".$info['id']."\"><input type=\"hidden\" name=\"friend\" value=\"".$_GET['friend']."\"><input type=\"submit\" name=\"saveComment\" value=\"Inserisci commento\" onclick=\"return clientSideCommentsControl(this.form);\"><input type=\"reset\" value=\"Cancella\"></p></form>";
		 
		 echo "<h4 class=\"info\">Commenti</h4>";
		
		$commentsArray = explode('#',$info['comments'],-1);
		
		for($i=0;$i<count($commentsArray);$i++){

			echo "<p>".$commentsArray[$i]."</p><br>"; 
			$divideString = explode(':',$commentsArray[$i],-1);
			if($divideString[0]==$_SESSION['username'] | $_SESSION['administrator']==1){
			echo "<form class=\"form\" action=\"userfriend.php\" method=\"get\"><p><input type=\"text\" name=\"commentsText\" ><input type=\"hidden\" name=\"modifyComment\" value=\"".$info['id']."\"><input type=\"hidden\" name=\"friend\" value=\"".$_GET['friend']."\"><input type=\"hidden\" name=\"commentMessage\" value=\"".$commentsArray[$i]."\"><input type=\"submit\" name=\"submitModifyStatusComment\" value=\"Modifica\" onclick=\"return clientSideCommentsControl(this.form);\">";
		 echo "<input type=\"button\"  name=\"deleteComment\" value=\"Elimina commento\" onclick=\"location.href='userfriend.php?friend=".$_GET['friend']."&deleteStatusComment=".$info['id']."&commentMessage=".$commentsArray[$i]."';\"></p></form>";
			}
		 echo "<hr class=\"divide\">";

		}
		
		
		?></div>
    <?php
	}
	}
	
else
	echo("<p class=\"info2\">".$info['username']." non ha ancora scritto nessun messaggio di stato.</p>");
   
   ?>     
        <h3>Amici</h3>
 <?php       
        $qry = "SELECT sender,receiver FROM richiesteamicizia WHERE (sender = '".$info['username']."' OR receiver = '".$info['username']."') AND state = 2";
	$check = mysql_query($qry);
	$numberRows= mysql_num_rows($check);
	$friendFound="";

if($numberRows>0){
	echo("<ul>");
	
	while($info3 = mysql_fetch_array($check)){
		
	if($info3['sender']!=$info['username'])
		$friendFound=$info3['sender'];
	else
		$friendFound=$info3['receiver'];
		 echo "<li><a href=\"userfriend.php?friend=",$friendFound,"\">",$friendFound,"</a></li>";
	}
	echo("</ul>");
	}
	
else
	echo("<p class=\"info2\">Non è presente nessun utente di PartySmile nella lista degli amici di ".$info['username']."</p>");
?>
        
        <h3>Fotografie</h3>
 <?php      
          $lista_file = caricaDirectory($_GET['friend']);
         if (count($lista_file) > 0) {
               echo "<ul>";
               for ($i = 0; $i < count($lista_file); $i++) {
                     echo "<li>", generaLinkImmagineFriend($_GET['friend'],$i, $lista_file[$i]);
					if($_SESSION['administrator']==1){
					 echo "<-<input class=\"button5\" type=\"button\"  name=\"deleteImage\" value=\"Elimina\" onclick=\"location.href='userfriend.php?friend=".$_GET['friend']."&amp;deleteImage=".$lista_file[$i]."';\">";
					}
								echo "</li>";
                               
               }       
          	   echo "</ul>";
         } else
              echo "\t<p class=\"info2\">Non è presente alcuna immagine all'interno della galleria fotografica di ".$info['username'].".</p>\n";
        
	
	} else 
		echo ("<p class=\"info2\">Non è possibile visualizzare le informazioni personali di un utente di PartySmile se non si è suo amico. Invia una richiesta d'amicizia ed attendi che il destinatario la accetti o meno.</p>");
	
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
    <p class="info" id="errorMessage2"><?php echo($errorMessage2); ?></p>
    <!-- end .sidebar2 --></div>
  <?php require("footer.php");?>
  <!-- end .container --></div>
</body>
</html>