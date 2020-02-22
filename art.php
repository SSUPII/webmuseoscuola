<?php
	header('Content-type: text/html; charset=iso-8859-1');

	$qr = "";
	$d = "";
	if(isset($_GET["d"]) && $_GET["d"] != "") $d = "d=$_GET[d]&";
	$qr = "http://127.0.0.1/webmuseoscuola/art.php?$d";

	if(isset($_GET["lang"])){
		$strings = array();
		switch($_GET["lang"]){
			case "en":{
				$strings[] = "en";
				$strings[] = "";
				$strings[] = "title";
				$strings[] = "type";
				$strings[] = "description";
				$strings[] = "It appers that we don't have a description for this work...";
				$strings[] = "We couldn't find this work on our database...";
				$strings[] = "This is no good!";
				$strings[] = "Ops... Looks like we got an error!";
				break;
			}
			case "it":{
				$strings[] = "it";
				$strings[] = "";
				$strings[] = "titolo";
				$strings[] = "tipo";
				$strings[] = "descrizione";
				$strings[] = "Non abbiamo una descrizione per questa opera...";
				$strings[] = "Non siamo riusciti a trovare questa opera nel nostro database...";
				$strings[] = "Questo è male!";
				$strings[] = "Ops... Si è verificato un errore!";
				break;
			}
			default:{
				header("Location: $qr"."lang=en");
				exit();
			}
		}
	}
	else {
		header("Location: $qr"."lang=en");
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
        <img style="float: left;" src="./res/img/lang.png" /><a href="./home.php?lang=it">Italiano</a> <a href="./home.php?lang=en">English</a>
        <div class=headerCountainer>
            <a href="./home.php?lang=<?php echo $strings[0]; ?>"><img class=icon src="./res/icon.png" alt="Web Musei"></a>
        </div>
        <div class=bodyCountainer>
            <?php
                $connection = mysqli_connect("127.0.0.1","guest","","musei");
                if($connection != FALSE){
                    $sql = "SELECT $strings[2], $strings[3], immagine, $strings[4] FROM opere WHERE opere.$strings[2] = \"".str_replace("_"," ",$_GET["d"])."\"";
                    $result = mysqli_query($connection,$sql);
                    if($result != FALSE){
						if(mysqli_num_rows($result) > 0){
							while($data = mysqli_fetch_assoc($result)){
                                echo "<p class=title>".str_replace("_"," ",$_GET["d"])." (".$data[$strings[3]].")</p>";
								$string = str_replace(" ","_",$data[$strings[2]]);
								if($data["immagine"] == NULL)
									$img = "./res/img/missing.png";
								else
									$img = $data["immagine"];
                                if($data[$strings[4]] == "" || $data[$strings[4]] == NULL) $string = $strings[5];
								else $string = $data[$strings[4]];
                                echo "<a href='$img'><img src=$img class=fullArt /></a><p>$string</p>";
								}
							}
							else {
								echo "<div style='text-align: center'><img src='./res/img/nothing.png' class=thumb /><p style='align: center'>$strings[6]</p>$strings[7]</div>";
							}
						}
						else {
							if($result == FALSE) echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>$strings[8]</p>Query error</div>";
						}
                }
            ?>
        </div>
    </body>
</html>
