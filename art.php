<?php
	header('Content-type: text/html; charset=iso-8859-1');
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
        <div class=headerCountainer>
            <a href="./index.htm"><img class=icon src="./res/icon.png" alt="Web Musei"></a>
        </div>
        <div class=bodyCountainer>
            <?php
                $connection = mysqli_connect("127.0.0.1","guest","","musei");
                if($connection != FALSE){
                    $sql = "SELECT titolo, tipo, immagine, descrizione FROM opere WHERE opere.titolo = \"".str_replace("_"," ",$_GET["d"])."\"";
                    $result = mysqli_query($connection,$sql);
                    if($result != FALSE){
						if(mysqli_num_rows($result) > 0){
							while($data = mysqli_fetch_assoc($result)){
                                echo "<p class=title>".str_replace("_"," ",$_GET["d"])." ($data[tipo])</p>";
								$string = str_replace(" ","_",$data["titolo"]);
								if($data["immagine"] == NULL)
									$img = "./res/img/missing.png";
								else
									$img = $data["immagine"];
                                if($data["descrizione"] == "" || $data["descrizione"] == NULL) $string = "It appers that we don't have a description for this work...";
								else $string = $data["descrizione"];
                                echo "<a href='$img'><img src=$img class=fullArt /></a><p>$string</p>";
								}
							}
							else {
								echo "<div style='text-align: center'><img src='./res/img/nothing.png' class=thumb /><p style='align: center'>We couldn't find this work on our database...</p>This is no good!</div>";
							}
						}
						else {
							if($result == FALSE) echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>Ops... Looks like we got an error!</p>Query error</div>";
						}
                }
            ?>
        </div>
    </body>
</html>
