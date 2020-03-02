<?php
	header('Content-type: text/html; charset=iso-8859-1');
	if(isset($_GET["lang"])){
		$strings = array();
		switch($_GET["lang"]){
			case "en":{
				$strings[] = "en";
				$strings[] = "Login";
				$strings[] = "Register";
				$strings[] = "This username is already taken";
				$strings[] = "Registration completed";
				break;
			}
			case "it":{
				$strings[] = "it";
				$strings[] = "Accesso";
				$strings[] = "Registra";
				$strings[] = "Questo username è stato già usato";
				$strings[] = "Registrazione completata";
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
		<a href="../index.htm"><img style="float: left;" src="../res/img/back.png" /></a><img style="float: left;" src="../res/img/lang.png" /><a href="./login.php?lang=it">Italiano</a> <a href="./login.php?lang=en">English</a>
        <div class=headerCountainer>
            <a href="../home.php?lang=<?php echo $strings[0]; ?>"><img class=icon src="../res/icon.png" alt="Web Musei" title="Home"></a>
        </div>
        <div class=bodyCountainer>
            <p class=title><?php echo $strings[1]; ?></p>
			<div class=listCountainer>
				<div class=list style="border: none;">
					<div style="text-align: center">
						<script type="text/javascript">
							var submited = "undefined";
						</script>
						<p style="color: #FF0000"><?php 
						if(isset($_GET["err"])){
							switch($_GET["err"]){
								case "-1":{
									echo $strings[4];
									break;
								}
								case "1":{
									echo $strings[3];
									break;
								}
							}
						}
						?></p>
						<form name=log action="" method=POST onsubmit="checkps()">
							Username <input type=text name=user required><br>
							Password <input type=password name=pass required><br>
							<input type=submit value=<?php echo "\"$strings[1]\""; ?>> <input type=submit onclick="submited='reg'" value=<?php echo "\"$strings[2]\""; ?>>
							<script type="text/javascript">
							var urlstr = window.location.href;
							var url = new URL(urlstr);
							var lang = url.searchParams.get("lang");
							function checkps(){
								if(submited == "reg"){
									var ps = document.getElementsByName("pass")[0].value;
									var string1 = "";
									var string2 = "";
									switch(lang){
										case "en":{
											string1 = "Please type your password again.";
											break;
										}
										case "it":{
											string1 = "Per favore inserisci la password di nuovo.";
											break;
										}
									}

									var psstring = "";
									do{
										psstring = prompt(string1);
									}while(psstring != ps && psstring != null);
									if(psstring == null){
										document.log.action = urlstr;
									}else{
										document.log.action = "./registration.php?lang="+lang;
									}
								}else{
									document.log.action = "./sessionstart.php?lang="+lang;
								}
								submited = "undefined";
							}
							</script>
						</form>
					</div>
				</div>
			</div>
        </div>
    </body>
</html>
