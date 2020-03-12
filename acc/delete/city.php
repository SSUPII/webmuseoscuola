<?php
	header("Content-Type: text/html; charset=UTF-8");
	if(isset($_GET["lang"])){
		$strings = array();
		switch($_GET["lang"]){
			case "en":{
				$strings[] = "en";
				$strings[] = "Go back";
				$strings[] = "City";
				$strings[] = "Delete";
				break;
			}
			case "it":{
				$strings[] = "it";
				$strings[] = "Torna indietro";
				$strings[] = "Citta'";
				$strings[] = "Elimina";
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
	mysqli_set_charset($connection,"UTF-8");
	if($connection != FALSE){
		$sql = "SELECT * FROM users WHERE id = \"$_SESSION[usri]\"";
		$result = mysqli_query($connection,$sql);
		if($result != FALSE && mysqli_num_rows($result) > 0){
			$userLevel = mysqli_fetch_assoc($result)["level"];
			if($userLevel < 1){
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
		$sql = "DELETE FROM musei.opere WHERE codCitta = $_POST[cid]";
		$result = mysqli_query($connection,$sql);
		if($result != FALSE){
			header("Location: http://127.0.0.1/webmuseoscuola/acc/dashboard.php?lang=$strings[0]&err=0");
		}else echo "error";
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" href="./favicon.ico" />
        <link rel="stylesheet" href="../../res/style/style.css" type="text/css" />
		<link rel="stylesheet" href="../../res/style/forms.css" type="text/css" />
        <title>Web Musei</title>
		<meta charset=UTF-8>
    </head>
    <body>
        <div class=headerCountainer>
            <a href="../../start.php?lang=<?php echo $strings[0]; ?>"><img class=icon src="../../res/icon.png" alt="Web Musei" title="Home"></a>
        </div>
		<div class=bodyCountainer>
			<div style="text-align: center;"><a href="../dashboard.php?lang=<?php echo "$strings[0]"; ?>"><?php echo $strings[1]; ?></a></div>
			<input type=hidden id=lang value="<?php echo $strings[0]; ?>">
			<p class=title><?php echo "$strings[3] $strings[2]"; ?></p>
			<div class=choice>
				<form action=# method=post>
					<select name=cid style="@charset "utf-8";">
						<?php
							$result = mysqli_query($connection,"SELECT codCitta, nome, name, nazione, nation FROM citta");
							if($result != FALSE && mysqli_num_rows($result) > 0){
								while($data = mysqli_fetch_assoc($result)){
									switch($_GET["lang"]){
										case "en":{
											echo "<option value=$data[codCitta]>$data[name] - $data[nation]</option>";
											break;
										}
										case "it":{
											echo "<option value=$data[codCitta]>$data[nome] - $data[nazione]</option>";
											break;
										}
									}
								}
							}else{
								echo "<option value=-1>Error</option>";
							}
						?>
					</select>
					<input type=submit name=send value=<?php echo $strings[3]; ?> />
				</form>
			</div>
		</div>
    </body>
</html>
