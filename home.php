<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" href="./favicon.ico" />
        <meta charset=utf-8 />
        <link rel="stylesheet" href="./res/style/style.css" type="text/css" />
        <title>Web Musei</title>
    </head>
    <body>
        <div class=headerCountainer>
            <a href="./index.htm"><img class=icon src="./res/icon.png" alt="Web Musei"></a>
        </div>
        <div class=bodyCountainer>
            <p class=title>Choose a city. You will see every museum and artist from that city!</p>
			<div class=content>
			  <?php
			    $connection = mysqli_connect("127.0.0.1","user","","museo");
			    if($connection != FALSE){
			      $sql = "SELECT nome FROM citta ORDER BY nome";
			      $result = mysqli_query($connection,$sql);
			      if($result != FALSE){
			        while($data = mysqli_fetch_assoc($result)){
			          
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
