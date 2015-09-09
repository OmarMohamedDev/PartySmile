<?php 

require './php_resources/check_session.php';
	require './php_resources/dbConn.php';
	require_once("./php_resources/config.php");
    require_once("./php_resources/function.php");

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
				
				header("Location: pictures.php?username=".$_GET['username']."&index=".$_GET['index']."&src=".$_GET['src']);
				
		} 

 
	require("./php_resources/gallery.php");
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
      <li><a href="friends.php">Amici</a></li>
      <li class="selected">Foto</li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <!-- end .sidebar1 --></div>
  <div class="content" id="content">
    <h1>Foto</h1>
    
    <?php 
	
	if(isset($_GET['deleteImage'])){
 
           dbConnect();
		   
		   $qry = "DELETE FROM `dbomarmohamed`.`immagini` WHERE `src` = '".$_GET ['deleteImage']."'";
   				$check = mysql_query($qry);
			mysql_close();
			
			unlink (DIR_IMMAGINI_GRANDI."/preview_".$_GET['deleteImage']);
			unlink (DIR_IMMAGINI_PICCOLE . "/small_".$_GET['deleteImage']);

	}
	
	if(isset($_POST['submit'])){
	
	if (!isset($_FILES["nomefile"])) die("File non ricevuto\n");
                $tmp_nome = $_FILES["nomefile"]["tmp_name"];
                $tipo = $_FILES["nomefile"]["type"];
                $nome = $_FILES["nomefile"]["name"];
            if (!controllaTipo($tipo)) die("File di tipo sconosciuto\n");
            if (move_uploaded_file($tmp_nome, DIR_IMMAGINI . "/" . $nome)){
                
                $immagine_sorgente = imagecreatefromjpeg(DIR_IMMAGINI . "/" . $nome);
                $larghezza_sorgente = imagesx($immagine_sorgente);
                $altezza_sorgente = imagesy($immagine_sorgente);
                $larghezza_nuova = 400;
                $altezza_nuova = 300;
                $immagine_nuova = imagecreatetruecolor($larghezza_nuova, $altezza_nuova);
                imagecopyresampled($immagine_nuova, $immagine_sorgente, 0, 0, 0, 0, 
				$larghezza_nuova, $altezza_nuova, $larghezza_sorgente, $altezza_sorgente);
                imagejpeg($immagine_nuova, DIR_IMMAGINI_GRANDI."/preview_".$nome."",100); 
                
                $immagine_sorgente = imagecreatefromjpeg(DIR_IMMAGINI . "/" . $nome);
                $larghezza_sorgente = imagesx($immagine_sorgente);
                $altezza_sorgente = imagesy($immagine_sorgente);
                $larghezza_nuova = 130;
                $altezza_nuova = 110;
                $immagine_nuova = imagecreatetruecolor($larghezza_nuova, $altezza_nuova);
            imagecopyresampled($immagine_nuova, $immagine_sorgente, 0, 0, 0, 0, 
				$larghezza_nuova, $altezza_nuova, $larghezza_sorgente, $altezza_sorgente);
            imagejpeg($immagine_nuova, DIR_IMMAGINI_PICCOLE."/small_".$nome."",100); 
            
                    dbConnect();
                    $sqlquery="INSERT INTO immagini (username,src) VALUES ('".$_SESSION['username']."','".$nome."')";
                    mysql_query($sqlquery);
                    mysql_close();
                    
                    if (file_exists(DIR_IMMAGINI . "/" . $nome))  
                            unlink (DIR_IMMAGINI . "/" . $nome); 
                    
                    }
	}
	
	if(isset($_GET['index'])){
         $actualImageIndex=$_GET['index'];
         $actualSrc=$_GET['src'];
         
         ?> <script type="text/javascript">openGallery('<?php echo $actualSrc ?>',<?php echo $actualImageIndex ?>);</script> <?php
     }
	
	 
	  if(isset($_GET['newComment'])){
		 $lista_file = caricaDirectory($_SESSION['username']);
		 
		 require "./php_resources/commentsControl.php";
		 
		 if($flag==true){
         
     		dbConnect();
             $sql1 = "SELECT comments FROM immagini WHERE src = '".$lista_file[$_GET['index']]."'";
					$result= mysql_query($sql1);
					$oldComment = mysql_fetch_row($result);
					
					$sql2 = "UPDATE immagini SET comments = '".$oldComment[0]."".$_SESSION['username'].": ".$_GET['commentsText']."#' WHERE src = '".$lista_file[$_GET['index']]."'";
					mysql_query($sql2);  
					mysql_close();
		 }
		 
		?><script type="text/javascript"> 
            location.replace("./pictures.php?username=<?php echo $_GET['username'] ?>&index=<?php echo $_GET['index'] ?>&src=<?php echo $_GET['src'] ?>");
            </script> <?php
            
     }
     
        ?>
    
    <h3>Inserisci una nuova immagine</h3>
    
    <form class="form2" action="pictures.php" method="post" enctype="multipart/form-data">
         <p>File da caricare<br>
            <input type="file" name="nomefile"><br>
            <input class="button2" type="submit" name="submit" value="Invia"></p>
        </form>
        
        <h3>La tua galleria fotografica</h3>
    
    <?php
                            $lista_file = caricaDirectory($_SESSION['username']);
                            if (count($lista_file) > 0) {
                                echo "<ul>";
                            for ($i = 0; $i < count($lista_file); $i++) {
                                echo "<li>", generaLinkImmagine($_SESSION['username'],$i, $lista_file[$i]);
							    echo "<-<input class=\"button5\" type=\"button\" name=\"deleteImage\" value=\"Elimina\" onclick=\"location.href='pictures.php?deleteImage=".$lista_file[$i]."';\">";
								echo "</li>";
                               
                            }       
                            echo "</ul>";
                            } else
                                echo "\t<p class=\"info2\">Non è presente alcuna immagine all'interno della tua galleria fotografica.</p>\n";
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