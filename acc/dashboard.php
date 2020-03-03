<?php
	header('Content-type: text/html; charset=iso-8859-1');
	if(isset($_GET["lang"])){
		$strings = array();
		switch($_GET["lang"]){
			case "en":{
				$strings[] = "en";
				$strings[] = "Leave the dashboard";
				break;
			}
			case "it":{
				$strings[] = "it";
				$strings[] = "Lascia il cruscotto virtuale";
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
        <title>Web Musei</title>
    </head>
    <body>
        <div class=headerCountainer>
            <a href="../start.php?lang=<?php echo $strings[0]; ?>"><img class=icon src="../res/icon.png" alt="Web Musei" title="Home"></a>
        </div>
		<div class=bodyCountainer>
			<div style="text-align: center;"><a href="../start.php?lang=?<?php echo "$strings[0]"; ?>"><?php echo $strings[1]; ?></a></div>
		</div>
    </body>
</html>
