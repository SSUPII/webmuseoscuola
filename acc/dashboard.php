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
				$strings[] = "You have been banned from contributing.";
				$strings[] = "You are not allowed to do that";
				$strings[] = "Success";
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
				$strings[] = "Sei stato bandito, non puoi più contribuire.";
				$strings[] = "Non hai i permessi per farlo";
				$strings[] = "Successo";
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
			<div style="text-align: center;"><a href="../start.php?lang=<?php echo $strings[0]; ?>"><?php echo $strings[1]; ?></a></div>
			<input type=hidden id=lang value="<?php echo $strings[0]; ?>">
			<script type="text/javascript">
				var lang = document.getElementById("lang");

				function getChoice(element){
					var choice;
					switch(element.value){
						case "0":{
							choice = "city";
							break;
						}
						case "1":{
							choice = "museum";
							break;
						}
						case "2":{
							choice = "artist";
							break;
						}
						case "3":{
							choice = "work";
							break;
						}
						default:{
							choice = null;
						}
					}
					return choice;
				}

				function insertChoiceHandler(){
					var choiceElement = document.getElementById("insertChoice");
					var choice = getChoice(choiceElement);
					if(choice != null) window.location = "./insert/"+choice+".php?lang="+lang.value;
				}

				function deteleChoiceHandler(){
					var choiceElement = document.getElementById("deleteChoice");
					var choice = getChoice(choiceElement);
					if(choice != null) window.location = "./delete/"+choice+".php?lang="+lang.value;
				}
				
				function banChoiceHandler(){
					window.location = "./moderation/bans.php?lang="+lang.value;
				}

				function promoteChoiceHandler(){
					window.location = "./moderation/promotions.php?lang="+lang.value;
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
						}else{
							echo "<div class=choice><p style='color: red; font-style: italic'>$strings[11]</p></div>";
						}

					}else{
						header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]&err=3");
					}
				}else{
					header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]&err=4");
				}

				if(isset($_GET["err"])){
					switch($_GET["err"]){
						case '0':{
							echo "<div class=choice><p style='color: red; font-style: italic'>$strings[13]</p></div>";
							break;
						}
						case '1':{
							echo "<div class=choice><p style='color: red; font-style: italic'>$strings[12]</p></div>";
							break;
						}
					}
				}
			?>
			
		</div>
    </body>
</html>
