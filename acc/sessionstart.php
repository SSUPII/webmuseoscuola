<?php
	header('Content-type: text/html; charset=iso-8859-1');
	if(isset($_GET["lang"])){
		$strings = array();
		switch($_GET["lang"]){
			case "en":{
				$strings[] = "en";
				break;
			}
			case "it":{
				$strings[] = "it";
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
?>
<!DOCTYPE html>
<html lang=en>
    <head>
        <link rel="icon" href="./favicon.ico" />
        <meta charset=iso-8859-1>
        <title>Web Musei</title>
    </head>
    <body>
		Logging in...
		<?php
			if(isset($_POST["user"]) && isset($_POST["pass"])){
				$connection = mysqli_connect("127.0.0.1","guest","","musei");
				if($connection != FALSE){
					$sql = "SELECT id, hash FROM users WHERE username = \"$_POST[user]\"";
					$result = mysqli_query($connection,$sql);
					if($result != FALSE && mysqli_num_rows($result) > 0){
						$data = mysqli_fetch_assoc($result);
						if(sha1($_POST["pass"]) == $data["hash"]){
							session_start();
							$_SESSION["usri"] = $data["id"];
							echo $_SESSION["usri"];
							header("Location: http://127.0.0.1/webmuseoscuola/acc/dashboard.php?lang=$strings[0]");
						}else header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]&err=5");
					}else header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]&err=2");
				}else {
					header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]");
				}
			}else {
				header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]");
			}

		?>
    </body>
</html>
