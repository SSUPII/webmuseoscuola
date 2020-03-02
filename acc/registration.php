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
		Creating...
		<?php
			if(isset($_POST["user"]) && isset($_POST["pass"])){
				$connection = mysqli_connect("127.0.0.1","root","","musei");
				if($connection != FALSE){
					$sql = "SELECT username FROM users WHERE username = \"$_POST[user]\"";
					$result = mysqli_query($connection,$sql);
					if($result != FALSE && mysqli_num_rows($result) > 0){
						header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]&err=1");
					}else{
						$length = 24;
						$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						$charactersLength = strlen($characters);
						do{
							$randomString = '';
							for ($i = 0; $i < $length; $i++) {
								$randomString .= $characters[rand(0, $charactersLength - 1)];
							}
						}while(mysqli_num_rows(mysqli_query($connection,"SELECT id FROM users WHERE id = \"$randomString\"")) > 0);
						$sql = "INSERT INTO users VALUES (\"$randomString\", \"$_POST[user]\", \"".sha1($_POST["pass"])."\", 0)";
						$result = mysqli_query($connection,$sql);
						if($result != FALSE){
							header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]&err=-1");
						}
					}
				}else {
					header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]");
				}
			}else {
				header("Location: http://127.0.0.1/webmuseoscuola/acc/login.php?lang=$strings[0]");
			}

		?>
    </body>
</html>
