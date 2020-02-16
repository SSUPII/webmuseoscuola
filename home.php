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
            <p class=title>Choose a city. You will see every museum and artist from that city! à</p>
			<div class=list>
			  <?php
			    $connection = mysqli_connect("127.0.0.1","guest","","musei");
			    if($connection != FALSE){
			      $sql = "SELECT nome FROM citta ORDER BY nome";
			      $result = mysqli_query($connection,$sql);
			      if($result != FALSE || mysqli_num_rows() > 0){
			        while($data = mysqli_fetch_assoc($result)){
					  $string = str_replace(" ","_",$data["nome"]);
			          echo "<div class=content><a href=./city.php?d=$string>$data[nome]</a></div>";
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
