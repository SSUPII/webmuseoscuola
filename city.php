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
            <p class=title>Awesome! Now choose a museum or artist from that city.</p>
            <div class=listHolder>
                <div class=list>
                    <div class="content listTitle">Museums</div>
                    <?php
			        $connection = mysqli_connect("127.0.0.1","guest","","musei");
			        if($connection != FALSE){
						$sql = "SELECT musei.nome, musei.immagine FROM musei, citta WHERE citta.codCitta = musei.codCitta AND citta.nome = \"".str_replace("_"," ",$_GET["d"])."\" ORDER BY musei.nome";
						$result = mysqli_query($connection,$sql);
						if($result != FALSE){
							if(mysqli_num_rows($result) > 0){
								while($data = mysqli_fetch_assoc($result)){
									$string = str_replace(" ","_",$data["nome"]);
									if($data["immagine"] == NULL)
										$img = "./res/img/missing.png";
									else
										$img = $data["immagine"];
									echo "<a href=./museum.php?d=$string><div class=content style='border-bottom: 1px solid #F0F0F0; font-size: 3.5vh; height: 130px;'><img src=$img class=thumb />$data[nome]</div></a>";
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
                    <div class="content listTitle">Artists</div>
					<?php
			        if($connection != FALSE){
						$sql = "SELECT artisti.nome, artisti.immagine FROM artisti, citta WHERE citta.codCitta = artisti.codCitta AND citta.nome = \"".str_replace("_"," ",$_GET["d"])."\" ORDER BY artisti.nome";
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
