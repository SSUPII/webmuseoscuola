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
            <p class=title>Choose a city. You will see every museum and artist from that city!</p>
			<div class=list>
			  <?php
			    $connection = mysqli_connect("127.0.0.1","guest","","musei");
			    if($connection != FALSE){
			      $sql = "SELECT nome, immagine FROM citta ORDER BY nome";
			      $result = mysqli_query($connection,$sql);
			      if($result != FALSE || mysqli_num_rows($result) > 0){
			        while($data = mysqli_fetch_assoc($result)){
					  $string = str_replace(" ","_",$data["nome"]);
					  if($data["immagine"] == NULL)
						$img = "./res/img/missing.png";
					  else
					    $img = $data["immagine"];

			          echo "<a href=./city.php?d=$string><div class=content style='border-bottom: 1px solid #F0F0F0; font-size: 3.5vh;'><img src=$img class=thumb />$data[nome]</div></a>";
			        }
			      }
			    }
			    else {
					echo "<p>An error has occurred</p>".mysqli_connect_error();
			    }
			  ?>
			</div>
        </div>
    </body>
</html>
