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
            <p class=title><?php echo str_replace("_"," ",$_GET["d"]); ?></p>
            <div class=listHolder>
                <div class=description>
                    <?php
			        $connection = mysqli_connect("127.0.0.1","guest","","musei");
			        if($connection != FALSE){
						$sql = "SELECT artisti.immagine, artisti.descrizione FROM artisti WHERE artisti.nome = \"".str_replace("_"," ",$_GET["d"])."\"";
						$result = mysqli_query($connection,$sql);
						if($result != FALSE){
							if(mysqli_num_rows($result) > 0){
								while($data = mysqli_fetch_assoc($result)){
									if($data["immagine"] == NULL)
										$img = "./res/img/missing.png";
									else
										$img = $data["immagine"];
									if($data["descrizione"] == "") $string = "It appers that we don't have a description for this artist";
									else $string = $data["descrizione"];
									echo "<img src=$img class=full /><p>$string</p>";
								}
							}
							else {
								echo "<div style='text-align: center'><img src='./res/img/nothing.png' class=thumb /><p style='align: center'>We couldn't find anything on our database...</p>What a shame!</div>";
							}
						}
						else {
							if($result == FALSE) echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>Ops... Looks like we got an error!</p>Query error</div>";
						}
					}
					else {
						echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>Ops... Looks like we got an error!</p>".mysqli_connect_error()."</div>";
				    }
			    ?>
                </div>
            </div>
            <div class=listHolder style="left: 50%;">
                <div class=list>
                    <div class="content listTitle">Works</div>
					<?php
			        if($connection != FALSE){
						$sql = "SELECT opere.titolo, opere.tipo, opere.immagine FROM opere, artisti WHERE artisti.codArtista = opere.codArtista AND artisti.nome = \"".str_replace("_"," ",$_GET["d"])."\" ORDER BY opere.titolo";
						$result = mysqli_query($connection,$sql);
						if($result != FALSE){
							if(mysqli_num_rows($result) > 0){
								while($data = mysqli_fetch_assoc($result)){
									$string = str_replace(" ","_",$data["nome"]);
									if($data["immagine"] == NULL)
										$img = "./res/img/missing.png";
									else
										$img = $data["immagine"];
									echo "<a href=./artist.php?d=$string><div class=content style='border-bottom: 1px solid #F0F0F0; font-size: 3.5vh; height: 130px;'><img src=$img class=thumb />$data[nome]</div></a>";
								}
							}
							else {
								echo "<div style='text-align: center'><img src='./res/img/nothing.png' class=thumb /><p style='align: center'>We couldn't find anything on our database...</p>What a shame!</div>";
							}
						}
						else {
							if($result == FALSE) echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>Ops... Looks like we got an error!</p>Query error</div>";
						}
					}
					else {
						echo "<div style='text-align: center'><img src='./res/img/error.png' class=thumb /><p style='align: center'>Ops... Looks like we got an error!</p>".mysqli_connect_error()."</div>";
				    }
			    ?>
                </div>
            </div>
        </div>
    </body>
</html>
