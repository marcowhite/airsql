<?php
// Соединямся с БД
$link=mysqli_connect("localhost", "mysql", "123", "airsql");
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
	{
	    $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
	    $userdata = mysqli_fetch_assoc($query);
	   	if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id']) or (intval($userdata['user_status']) !== 2)
	 	or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "0")))
	    {
	    header("Location: /profile/"); exit();
	    }
	 }
if(isset($_POST['submit']))
{
	if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
	{
	    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id']) or (intval($userdata['user_status']) !== 2)
	 	or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "0")))
	    {
	        setcookie("id", "", time() - 3600*24*30*12, "/");
	        setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
	        print "Что-то пошло не так.";
	    }
	    else
	    {
        mysqli_query($link, 
			"INSERT INTO `races`
			(`bus_type_id`, `IATA_from`, `IATA_to`, `date_from`, `date_to`) 
			VALUES (
			'".intval($_POST['bus_type_id'])."',
			'".mysqli_real_escape_string($link,$_POST['IATA_from'])."',
			'".mysqli_real_escape_string($link,$_POST['IATA_to'])."',
			'".mysqli_real_escape_string($link,$_POST['date_from_date'])." ".mysqli_real_escape_string($link,$_POST['date_from_time'])."',
			'".mysqli_real_escape_string($link,$_POST['date_to_date'])." ".mysqli_real_escape_string($link,$_POST['date_to_time'])."')");
        header("Location: /profile/manage.php"); exit();
    	}
    }
    else
    {
        print "Включите куки";
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
		$query = 'SELECT * FROM races';
		$result = mysqli_query($link, $query) or die('Запрос не удался: ' . mysqli_error());

		echo "<table>\n";
		while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		    echo "\t<tr>\n";
		    foreach ($line as $col_value) {
		        echo "\t\t<td>$col_value</td>\n";
		    }
		    echo "\t</tr>\n";
		}
		echo "</table>\n";
		mysqli_free_result($result);
		mysqli_close($link);
		?>
    <p>Добавить рейс</p>
	    <form method="POST">
	    <p>Тип самолета:<input type="text" name="bus_type_id"/></p>
	 	<p>IATA аэропорта отправления: <input type="text" name="IATA_from"/></p>
	 	<p>IATA аэропорта прибытия: <input type="text" name="IATA_to"/></p>
	 	<p>Дата и время отправления: <input type="date" name="date_from_date"/><input type="time" name="date_from_time"/></p>
	 	<p>Дата и время прибытия: <input type="date" name="date_to_date"/><input type="time" name="date_to_time"/></p>
	 	<input name="submit" type="submit" value="Добавить">
		</form>
	<a href="http://air/profile">Назад</a>
	</div>
	</div>
</body>
</html>