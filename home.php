<?php
	header('Content-type: text/html; charset=iso-8859-1');
	if(isset($_GET["lang"])){
		$strings = array();
		switch($_GET["lang"]){
			case "en":{
				$strings[] = "en";
				$strings[] = "Choose a city. You will see every museum and artist from that city!";
				$strings[] = "name";
				$strings[] = "nation";
				$strings[] = "We couldn't find anything on our database...";
				$strings[] = "We'll try our best to fix this!";
				$strings[] = "Ops... Looks like we got an error!";
				$strings[] = "Login and contribute";
				break;
			}
			case "it":{
				$strings[] = "it";
				$strings[] = "Scegli una città. Vedrai ogni museo ed artista da quella città!";
				$strings[] = "nome";
				$strings[] = "nazione";
				$strings[] = "Non abbiamo trovato nulla nel nostro database...";
				$strings[] = "Faremo del nostro meglio per risolvere ciò!";
				$strings[] = "Ops... Si è verificato un errore!";
				$strings[] = "Accedi e contribuisci";
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
        <link rel="stylesheet" href="./res/style/style.css" type="text/css" />
		<link rel="stylesheet" href="./res/style/content.css" type="text/css" />
        <title>Web Musei</title>
    </head>
    <body>
		<a href="./index.htm"><img style="float: left;" src="./res/img/back.png" /></a><img style="float: left;" src="./res/img/lang.png" /><a href="./home.php?lang=it">Italiano</a> <a href="./home.php?lang=en">English</a> - <a href="./acc/login.php?lang=<?php echo $strings[0] ?>"><?php echo $strings[7] ?></a>
        <div class=headerCountainer>
            <a href="./home.php?lang=<?php echo $strings[0]; ?>"><img class=icon src="./res/icon.png" alt="Web Musei" title="Home"></a>
        </div>
        <div class=bodyCountainer>
            <p class=title><?php echo $strings[1]; ?></p>
			<div class=list style="height: 60vh;">
			    <?php
			        $connection = mysqli_connect("127.0.0.1","guest","","musei");
			        if($connection != FALSE){
						$sql = "SELECT $strings[2], immagine, $strings[3] FROM citta ORDER BY $strings[2]";
						$result = mysqli_query($connection,$sql);
						if($result != FALSE){
							if(mysqli_num_rows($result) > 0){
								while($data = mysqli_fetch_assoc($result)){
									$string = str_replace(" ","_",$data[$strings[2]]);
									if($data["immagine"] == NULL)
										$img = "./res/img/missing.png";
									else
										$img = $data["immagine"];
									echo "<a href=./city.php?d=$string&lang=$strings[0]><div class=content><img src=$img class=thumb />".$data[$strings[2]]." (".$data[$strings[3]].")</div></a>";
								}
							}
							else {
								echo "<div style='text-align: center'><img src='./res/img/nothing.png' class=thumb /><p style='align: center'>$strings[4]</p>$strings[5]</div>";
							}
						}
						else {
							if($result == FALSE) echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>$strings[6]</p>Query error</div>";
						}
					}
					else {
						echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>$strings[6]</p>".mysqli_connect_error()."</div>";
				    }
			    ?>
			</div>
        </div>
    </body>
</html>
