<?php
	header('Content-type: text/html; charset=iso-8859-1');

	$qr = "";
	$d = "";
	if(isset($_GET["d"]) && $_GET["d"] != "") $d = "d=$_GET[d]&";
	$qr = "http://127.0.0.1/webmuseoscuola/city.php?$d";

	if(isset($_GET["lang"])){
		$strings = array();
		switch($_GET["lang"]){
			case "en":{
				$strings[] = "en";
				$strings[] = "Awesome! Now choose a museum or artist from that city.";
				$strings[] = "name";
				$strings[] = "We couldn't find anything on our database...";
				$strings[] = "What a shame!";
				$strings[] = "Ops... Looks like we got an error!";
				break;
			}
			case "it":{
				$strings[] = "it";
				$strings[] = "Fantastico! Ora scegli un museo o artista da quella città.";
				$strings[] = "nome";
				$strings[] = "Non abbiamo trovato nulla nel nostro database...";
				$strings[] = "Che situazione imbarazzante!";
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
		<a href="./index.htm"><img style="float: left;" src="./res/img/back.png" /></a><img style="float: left;" src="./res/img/lang.png" /><a href="./home.php?lang=it">Italiano</a> <a href="./home.php?lang=en">English</a>
        <div class=headerCountainer>
            <a href="./home.php?lang=<?php echo $strings[0]; ?>"><img class=icon src="./res/icon.png" alt="Web Musei" title="Home"></a>
        </div>
        <div class=bodyCountainer>
            <p class=title><?php echo $strings[1]; ?></p>
            <div class=listHolder>
                <div class=list>
                    <div class="listTitle">Museums</div>
                    <?php
			        $connection = mysqli_connect("127.0.0.1","guest","","musei");
			        if($connection != FALSE && isset($_GET["d"])){
						$sql = "SELECT musei.$strings[2], musei.immagine FROM musei, citta WHERE citta.codCitta = musei.codCitta AND citta.$strings[2] = \"".str_replace("_"," ",$_GET["d"])."\" ORDER BY musei.$strings[2]";
						$result = mysqli_query($connection,$sql);
						if($result != FALSE){
							if(mysqli_num_rows($result) > 0){
								while($data = mysqli_fetch_assoc($result)){
									$string = str_replace(" ","_",$data[$strings[2]]);
									if($data["immagine"] == NULL)
										$img = "./res/img/missing.png";
									else
										$img = $data["immagine"];
									echo "<a href=./museum.php?d=$string&lang=$strings[0]><div class=content><img src=$img class=thumb />".$data[$strings[2]]."</div></a>";
								}
							}
							else {
								echo "<div style='text-align: center'><img src='./res/img/nothing.png' class=thumb /><p style='align: center'>$strings[3]</p>$strings[4]</div>";
							}
						}
						else {
							if($result == FALSE) echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>$strings[5]</p>Query error</div>";
						}
					}
					else {
						echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>$strings[5]</p>".mysqli_connect_error()."</div>";
				    }
			    ?>
                </div>
            </div>
            <div class=listHolder style="float: right;">
                <div class=list>
                    <div class="listTitle">Artists</div>
					<?php
			        if($connection != FALSE && isset($_GET["d"])){
						$sql = "SELECT artisti.nome, artisti.immagine FROM artisti, citta WHERE citta.codCitta = artisti.codCitta AND citta.$strings[2] = \"".str_replace("_"," ",$_GET["d"])."\" ORDER BY artisti.nome";
						$result = mysqli_query($connection,$sql);
						if($result != FALSE){
							if(mysqli_num_rows($result) > 0){
								while($data = mysqli_fetch_assoc($result)){
									$string = str_replace(" ","_",$data["nome"]);
									if($data["immagine"] == NULL)
										$img = "./res/img/missing.png";
									else
										$img = $data["immagine"];
									echo "<a href=./artist.php?d=$string&lang=$strings[0]><div class=content><img src=$img class=thumb />$data[nome]</div></a>";
								}
							}
							else {
								echo "<div style='text-align: center'><img src='./res/img/nothing.png' class=thumb /><p style='align: center'>$strings[3]</p>$strings[4]</div>";
							}
						}
						else {
							if($result == FALSE) echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>$strings[5]</p>Query error</div>";
						}
					}
					else {
						echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>$strings[5]</p>".mysqli_connect_error()."</div>";
				    }
			    ?>
                </div>
            </div>
        </div>
    </body>
</html>
