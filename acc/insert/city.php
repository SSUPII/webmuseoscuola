<?php
	header('Content-type: text/html; charset=iso-8859-1');
	if(isset($_GET["lang"])){
		$strings = array();
		switch($_GET["lang"]){
			case "en":{
				$strings[] = "en";
				$strings[] = "Leave the dashboard";
				$strings[] = "Insert a new ";
				$strings[] = "City";
				$strings[] = "Museum";
				$strings[] = "Artist";
				$strings[] = "Work";
				$strings[] = "Delete a ";
				$strings[] = "Go";
				$strings[] = "Ban or unban a user ";
				$strings[] = "Promote/Demote a user to/from administrator ";
				break;
			}
			case "it":{
				$strings[] = "it";
				$strings[] = "Lascia il cruscotto virtuale";
				$strings[] = "Inserisci un/a nuovo/a ";
				$strings[] = "Citta";
				$strings[] = "Museo";
				$strings[] = "Artista";
				$strings[] = "Opera";
				$strings[] = "Elimina un/a ";
				$strings[] = "Vai";
				$strings[] = "Bandisci o libera un utente ";
				$strings[] = "Promuovi/Degrada un utente ad/da amministratore ";
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
	if(!isset($_SESSION["usri"])) header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]&err=3");
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" href="./favicon.ico" />
        <meta charset=utf-8 />
        <link rel="stylesheet" href="../res/style/style.css" type="text/css" />
		<link rel="stylesheet" href="../res/style/forms.css" type="text/css" />
        <title>Web Musei</title>
    </head>
    <body>
        <div class=headerCountainer>
            <a href="../start.php?lang=<?php echo $strings[0]; ?>"><img class=icon src="../res/icon.png" alt="Web Musei" title="Home"></a>
        </div>
		<div class=bodyCountainer>
			<div style="text-align: center;"><a href="../start.php?lang=?<?php echo "$strings[0]"; ?>"><?php echo $strings[1]; ?></a></div>
			<input type=hidden id=lang value="<?php echo $strings[0]; ?>">
			<script type="text/javascript">
				var lang = document.getElementById("lang");
				function insertChoiceHandler(){
					var choice = document.getElementById("insertChoice");
					window.location = "./insert/city.php?lang="+lang.value;
				}
			</script>
			<?php
				$connection = mysqli_connect("127.0.0.1","root","","musei");
				if($connection != FALSE){
					$sql = "SELECT * FROM users WHERE id = \"$_SESSION[usri]\"";
					$result = mysqli_query($connection,$sql);
					if($result != FALSE && mysqli_num_rows($result) > 0){
						$userLevel = mysqli_fetch_assoc($result)["level"];

						$layout = "";
						$levels = array();
						$levels[] = "
						<div class=choice>$strings[2]
							<select id='insertChoice'>
								<option value=0>$strings[3]</option>
								<option value=1>$strings[4]</option>
								<option value=2>$strings[5]</option>
								<option value=3>$strings[6]</option>
							</select>
							<input type=button onClick='insertChoiceHandler()' value=$strings[8]> 
						</div>";
						$levels[] = "
						<div class=choice>$strings[7]
							<select id='deleteChoice'>
								<option value=0>$strings[3]</option>
								<option value=1>$strings[4]</option>
								<option value=2>$strings[5]</option>
								<option value=3>$strings[6]</option>
							</select>
							<input type=button onClick='deteleChoiceHandler()' value=$strings[8]> 
						</div>
						<div class=choice>
							$strings[9]<input type=button onClick='banChoiceHandler()' value=$strings[8]> 
						</div>";
						$levels[] = "
						<div class=choice>
							$strings[10]<input type=button onClick='promoteChoiceHandler()' value=$strings[8]> 
						</div>";

						if($userLevel >= 0){
							for($i = 0; $i <= $userLevel; $i++){
								echo $levels[$i];
							}
						}

					}else{
						header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]&err=3");
					}
				}else{
					header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]&err=4");
				}
			?>
			
		</div>
    </body>
</html>
