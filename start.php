<?php
	header('Content-type: text/html; charset=iso-8859-1');
	if(isset($_GET["lang"])){
		$strings = array();
		switch($_GET["lang"]){
			case "en":{
				$strings[] = "en";
                $strings[] = "Welcome to ";
                $strings[] = "Web Musei";
                $strings[] = "Visit you dream museums like never before";
                $strings[] = "A place to visit your favourite museums with little to no trouble.";
                $strings[] = "Go!";
				break;
			}
			case "it":{
				$strings[] = "it";
                $strings[] = "Benvenuto su ";
                $strings[] = "Web Musei";
                $strings[] = "Visita i musei dei tuoi sogni come mai prima";
                $strings[] = "Un posto dove visitare i tuoi musei preferiti senza alcun sforzo.";
                $strings[] = "Vai!";
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
<html>
    <head>
        <link rel="icon" href="./favicon.ico" />
        <meta charset=utf-8 />
        <link rel="stylesheet" href="./res/style/style.css" type="text/css" />
        <title>Web Musei</title>
    </head>
    <body>
		<a href="./index.htm"><img style="float: left;" src="./res/img/back.png" /></a><img style="float: left;" src="./res/img/lang.png" /><a href="./start.php?lang=it">Italiano</a> <a href="./start.php?lang=en">English</a>
        <div class=headerCountainer>
            <a href="./start.php?lang=<?php echo $strings[0]; ?>"><img class=icon src="./res/icon.png" alt="Web Musei" title="Home"></a>
        </div>
        <div class=bodyCountainer>
            <p class="title"><?php echo $strings[1]; ?><span style="font-size: 150%"><?php echo $strings[2]; ?></span></p>
            <div class="featureCountainer" style="animation: ease fadeAnim 4s;">
                <p class="featureTitle"><?php echo $strings[3]; ?></p>
                <p class="description"><?php echo $strings[4]; ?></p>
            </div>
            <div class="featureCountainer" style="animation: ease fadeAnim 4s;">
                <p class="featureTitle">Changelog (English):</p>
                <p class=description>Beta 1.2:</p>
                <ul style="list-style-type: none;">
                    <li><p class=description>Website optimized for very small screens</p></li>
                </ul>
            </div>
            <div class="buttonCountainer">
                <input id="startButton" type="button" value="<?php echo $strings[5]; ?>" onclick="location.href = './home.php?lang=<?php echo $strings[0]; ?>';" />
            </div>
        </div>
    </body>
</html>
