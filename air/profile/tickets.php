<?php
$link=mysqli_connect("localhost", "mysql", "123", "airsql");
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
	{
	    $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
	    $userdata = mysqli_fetch_assoc($query);
	   	if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
	 	or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "0")))
	    {
	    header("Location: /profile/"); exit();
	    }
	 }
?>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Профиль</title>
  <link href="okinawa.html" rel="parent" charset="euc-jp">
  <link rel="stylesheet" type="text/css" href="http://air/css/main.css">
 </head>
 <body>
 	    <div id='header'>
        <div id='header-inner' class='container-fluid'>
        <h1>AirSQL</h1>
      </div>
    </div>
 	<div id='body-inner' class="container-fluid">
 		<div id='central' class='container-fluid'>		
		<?php

		$link = mysqli_connect("127.0.0.1", "mysql", "123", "airsql");
		if (mysqli_connect_errno()) {
		    printf("Не удалось подключиться: %s\n", mysqli_connect_error());
		    exit();
		}
		$query = 'SELECT * FROM tickets WHERE user_id = "'.intval($_COOKIE['id']).'"';
		$result = mysqli_query($link, $query) or die('Запрос не удался: ' . mysqli_error());

		echo "<table>\n";
		while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		    echo "\t<tr>\n";
		    foreach ($line as $col_value) {
		    	if ($col_value == $line['race_id'])
		    	{
		    		echo "\t\t<td>".$col_value."</td>\n";
		    		$query_race = 'SELECT * FROM races WHERE race_id = "'.$col_value.'"';
					$result_race = mysqli_query($link, $query_race) or die('Запрос не удался: ' . mysqli_error());
		    		$line_race = mysqli_fetch_array($result_race, MYSQLI_ASSOC);
		    		echo "\t\t<td>".$line_race['IATA_from']."</td>\n";
		    		echo "\t\t<td>".$line_race['IATA_to']."</td>\n";
		    		echo "\t\t<td>".$line_race['date_from']."</td>\n";
		    		echo "\t\t<td>".$line_race['date_to']."</td>\n";
		    	}
		    	else
		        echo "\t\t<td>".$col_value."</td>\n";
		    }
		    echo "\t</tr>\n";
		}
		echo "</table>\n";
		mysqli_free_result($result);
		mysqli_close($link);
		?>
	<a href="http://air/profile">Назад</a>
	</div>
	</div>
</body>
</html>