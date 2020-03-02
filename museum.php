<?php
	header('Content-type: text/html; charset=iso-8859-1');

	$qr = "";
	$d = "";
	if(isset($_GET["d"]) && $_GET["d"] != "") $d = "d=$_GET[d]&";
	$qr = "http://127.0.0.1/webmuseoscuola/museum.php?$d";

	if(isset($_GET["lang"])){
		$strings = array();
		switch($_GET["lang"]){
			case "en":{
				$strings[] = "en";
				$strings[] = "";
				$strings[] = "description";
				$strings[] = "name";
				$strings[] = "title";
				$strings[] = "type";
				$strings[] = "We couldn't find anything on our database...";
				$strings[] = "We'll try our best to fix this!";
				$strings[] = "Ops... Looks like we got an error!";
				$strings[] = "It appers that we don't have a description for this museum...";
				break;
			}
			case "it":{
				$strings[] = "it";
				$strings[] = "";
				$strings[] = "descrizione";
				$strings[] = "nome";
				$strings[] = "titolo";
				$strings[] = "tipo";
				$strings[] = "Non abbiamo trovato nulla nel nostro database...";
				$strings[] = "Faremo del nostro meglio per risolvere ciò!";
				$strings[] = "Ops... Si è verificato un errore!";
				$strings[] = "Non abbiamo una descrizione per questo museo...";
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
		<a href="./index.htm"><img style="float: left;" src="./res/img/back.png" /></a><img style="float: left;" src="./res/img/lang.png" /><a href="./home.php?lang=it">Italiano</a> <a href="./home.php?lang=en">English</a>
        <div class=headerCountainer>
            <a href="./home.php?lang=<?php echo $strings[0]; ?>"><img class=icon src="./res/icon.png" alt="Web Musei" title="Home"></a>
        </div>
        <div class=bodyCountainer>
            <p class=title><?php echo str_replace("_"," ",$_GET["d"]); ?></p>
            <div class=listHolder>
                <div class=description>
                    <?php
			        $connection = mysqli_connect("127.0.0.1","guest","","musei");
			        if($connection != FALSE){
						$sql = "SELECT musei.immagine, musei.$strings[2], indirizzo FROM musei WHERE musei.$strings[3] = \"".str_replace("_"," ",$_GET["d"])."\"";
						$result = mysqli_query($connection,$sql);
						if($result != FALSE){
							if(mysqli_num_rows($result) > 0){
								while($data = mysqli_fetch_assoc($result)){
									if($data["immagine"] == NULL)
										$img = "./res/img/missing.png";
									else
										$img = $data["immagine"];
									$string = "(".$data["indirizzo"].")<br>";
									if($data[$strings[2]] == "" || $data[$strings[2]] == NULL) $string .= $strings[9];
									else $string .= $data[$strings[2]];
									echo "<img src=$img class=full /><p>$string</p>";
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
					else {
						echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>$strings[8]</p>".mysqli_connect_error()."</div>";
				    }
			    ?>
                </div>
            </div>
            <div class=listHolder style="float: right">
                <div class=list>
                    <div class="listTitle">Works</div>
					<?php
			        if($connection != FALSE){
						$sql = "SELECT opere.$strings[4], opere.$strings[5], opere.immagine FROM opere, musei WHERE musei.codMuseo = opere.codMuseo AND musei.$strings[3] = \"".str_replace("_"," ",$_GET["d"])."\" ORDER BY opere.$strings[4]";
						$result = mysqli_query($connection,$sql);
						if($result != FALSE){
							if(mysqli_num_rows($result) > 0){
								while($data = mysqli_fetch_assoc($result)){
									$string = str_replace(" ","_",$data[$strings[4]]);
									if($data["immagine"] == NULL)
										$img = "./res/img/missing.png";
									else
										$img = $data["immagine"];
									echo "<a href=./art.php?d=$string&lang=$strings[0]><div class=content><img src=$img class=thumb />".$data[$strings[4]]."</div></a>";
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
					else {
						echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>$strings[8]</p>".mysqli_connect_error()."</div>";
				    }
			    ?>
                </div>
            </div>
        </div>
    </body>
</html>
