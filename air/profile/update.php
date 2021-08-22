<?php
// Соединямся с БД
$link=mysqli_connect("localhost", "mysql", "123", "airsql");

if(isset($_POST['submit']))
{
	if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
	{
	    $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
	    $userdata = mysqli_fetch_assoc($query);

	    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
	 	or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "0")))
	    {
	        setcookie("id", "", time() - 3600*24*30*12, "/");
	        setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
	        print "Что-то пошло не так.";
	    }
	    else
	    {
	    	$id=intval($_COOKIE['id']);
        // Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, 
        	"UPDATE users 
			SET
			name='".mysqli_real_escape_string($link,$_POST['name'])."',
			surname='".mysqli_real_escape_string($link,$_POST['surname'])."',
			patronymic = '".mysqli_real_escape_string($link,$_POST['patronymic'])."'
			WHERE user_id=$id");

        // Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: /profile/"); exit();
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
			    <p>Изменить данные</p>
			    <form method="POST">
			 	<p>Ваша фамилия: <input type="text" name="surname"/></p>
			 	<p>Ваше имя: <input type="text" name="name"/></p>
			 	<p>Ваше отчество: <input type="text" name="patronymic"/></p>
			 	<input name="submit" type="submit" value="Изменить">
				</form>
				<a href="http://air/profile">Назад</a>
			</div>
		</div>
 </body>
</html>