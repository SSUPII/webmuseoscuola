﻿<?php
	header('Content-type: text/html; charset=iso-8859-1');
	if(isset($_GET["lang"])){
		$strings = array();
		switch($_GET["lang"]){
			case "en":{
				$strings[] = "en";
				$strings[] = "Go back";
				$strings[] = "City";
				$strings[] = "Name";
				$strings[] = "Nation";
				$strings[] = "English";
				$strings[] = "Italian";
				$strings[] = "Image URL";
				$strings[] = "* = required";
				$strings[] = "Send";
				break;
			}
			case "it":{
				$strings[] = "it";
				$strings[] = "Torna indietro";
				$strings[] = "Città";
				$strings[] = "Nome";
				$strings[] = "Nazione";
				$strings[] = "Inglese";
				$strings[] = "Italiano";
				$strings[] = "URL Immagine";
				$strings[] = "* = richiesto";
				$strings[] = "Invia";
				break;
			}
			default:{
				header('Location: http://127.0.0.1/webmuseoscuola/index.htm');
				exit();
			}
		}
	}
	else {
		header('Location: http://127.0.0.1/webmuseoscuola/index.htm');
		exit();
	}
	session_start();
	if(!isset($_SESSION["usri"])){
		header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]&err=3");
		exit();
	}

	$connection = mysqli_connect("127.0.0.1","root","","musei");
	if($connection != FALSE){
		$sql = "SELECT * FROM users WHERE id = \"$_SESSION[usri]\"";
		$result = mysqli_query($connection,$sql);
		if($result != FALSE && mysqli_num_rows($result) > 0){
			$userLevel = mysqli_fetch_assoc($result)["level"];
			if($userLevel < 0){
				header("Location: http://127.0.0.1/webmuseoscuola/acc/dashboard.php?lang=$strings[0]&err=1");
				exit();
			}
		}else{
			header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]&err=3");
			exit();
		}
	}else{
		header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]");
		exit();
	}

	if(isset($_POST["send"])){
		$sql = "INSERT INTO citta (nome, name, nazione, nation, immagine) VALUES (\"$_POST[nameIT]\",\"$_POST[nameEN]\",\"$_POST[nationIT]\",\"$_POST[nationEN]\",\"$_POST[image]\")";
		$result = mysqli_query($connection,$sql);
		if($result != FALSE){
			header("Location: http://127.0.0.1/webmuseoscuola/acc/dashboard.php?lang=$strings[0]&err=0");
			exit();
		}else echo "error";
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" href="./favicon.ico" />
        <meta charset=utf-8 />
        <link rel="stylesheet" href="../../res/style/style.css" type="text/css" />
		<link rel="stylesheet" href="../../res/style/forms.css" type="text/css" />
        <title>Web Musei</title>
    </head>
    <body>
        <div class=headerCountainer>
            <a href="../../start.php?lang=<?php echo $strings[0]; ?>"><img class=icon src="../../res/icon.png" alt="Web Musei" title="Home"></a>
        </div>
		<div class=bodyCountainer>
			<div style="text-align: center;"><a href="../dashboard.php?lang=<?php echo "$strings[0]"; ?>"><?php echo $strings[1]; ?></a></div>
			<input type=hidden id=lang value="<?php echo $strings[0]; ?>">
			<p class=title><?php echo $strings[2]; ?></p>
			<div class=choice>
				<p style="text-align: center;"><?php echo $strings[8] ?></p>
				<form action=# method=post>
					<?php echo "$strings[3] ($strings[5])*"; ?> <input type=text name=nameEN required><br>
					<?php echo "$strings[3] ($strings[6])*"; ?> <input type=text name=nameIT required><br>
					<?php echo "$strings[4] ($strings[5])*"; ?> <input type=text name=nationEN required><br>
					<?php echo "$strings[4] ($strings[6])*"; ?> <input type=text name=nationIT required><br>
					<?php echo "$strings[7]"; ?> <textarea name=image></textarea><br>
					<input type=submit name=send value=<?php echo $strings[9]; ?> />
				</form>
			</div>
		</div>
    </body>
</html>
