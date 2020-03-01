<?php
	header('Content-type: text/html; charset=iso-8859-1');
	if(isset($_GET["lang"])){
		$strings = array();
		switch($_GET["lang"]){
			case "en":{
				$strings[] = "en";
				$strings[] = "Login";
				break;
			}
			case "it":{
				$strings[] = "it";
				$strings[] = "Accesso";
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
        <link rel="stylesheet" href="../res/style/style.css" type="text/css" />
		<link rel="stylesheet" href="../res/style/content.css" type="text/css" />
		<link rel="stylesheet" href="../res/style/forms.css" type="text/css" />
        <title>Web Musei</title>
    </head>
    <body>
		<a href="../index.htm"><img style="float: left;" src="../res/img/back.png" /></a><img style="float: left;" src="../res/img/lang.png" /><a href="../home.php?lang=it">Italiano</a> <a href="../home.php?lang=en">English</a>
        <div class=headerCountainer>
            <a href="../home.php?lang=<?php echo $strings[0]; ?>"><img class=icon src="../res/icon.png" alt="Web Musei" title="Home"></a>
        </div>
        <div class=bodyCountainer>
            <p class=title><?php echo $strings[1]; ?></p>
			<div class=listCountainer>
				<div class=list style="border: none;">
					<div style="text-align: center">
						<form>
							Username <input type=text><br>
							Password <input type=password><br>
							<input type=submit value="Login Placeholder"> <input type=button value="Register Placeholder">
						</form>
					</div>
				</div>
			</div>
        </div>
    </body>
</html>
