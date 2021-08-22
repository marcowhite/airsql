
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Заказ рейса</title>
  <link href="okinawa.html" rel="parent" charset="euc-jp">
  <link rel="stylesheet" type="text/css" href="http://air/css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">		
    	$('input[type="checkbox"]').on('change', function() {
		    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
		});
	</script>
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
            print "<p>Что-то пошло не так. Возможно вы не вошли в свой аккаунт</p>";
            echo "<p><a href='http://air/profile/login.php'>Войти</a></p>";
            echo "<p><a href='http://air/profile/register.php'>Регистрация</a></p>";
        }
        else
        {
            $selected_race = intval($_POST['race_input']);
            if (mysqli_connect_errno()) {
                printf("Не удалось подключиться: %s\n", mysqli_connect_error());
                exit();
            }
            function IATA_request($link,$id)
            {
             $query= "SELECT * FROM iata_codes WHERE iata_id='$id'";
             $request = mysqli_query($link, $query) or die('Запрос не удался: ' . mysqli_error());
             $line = mysqli_fetch_array($request, MYSQLI_ASSOC);
             $func = $line['airport_name'];
             return $func;
            }
            $query = "SELECT * FROM races WHERE race_id=$selected_race";
            $result = mysqli_query($link, $query) or die('Запрос не удался: ' . mysqli_error());
            $line = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $IATA_from = IATA_request($link,$line['IATA_from']);
            $IATA_to = IATA_request($link,$line['IATA_to']);
            //echo "<p>Номер выбранного рейса <input size='10' type='text' name='selected_race' 
            //value='$selected_race' readonly></p>";
            echo "<p>Место отправления <input size='45' type='text'
            value='".$line['IATA_from'].": $IATA_from' readonly></p>";
            echo "<p>Место прибытия <input size='45' type='text'
            value='".$line['IATA_to'].": $IATA_to' readonly></p>";
            echo "<p>Дата отправления <input size='17' type='text'
            value='".$line['date_from']."' readonly></p>";
            echo "<p>Дата прибытия <input size='17' type='text'
            value='".$line['date_to']."' readonly></p>";
            $bus_type = intval($line['bus_type_id']);
            $query = "SELECT * FROM buses WHERE bus_type_id = '".$bus_type."' LIMIT 1";
            $result = mysqli_query($link, $query) or die('Запрос не удался: ' . mysqli_error());
            $line = mysqli_fetch_array($result, MYSQLI_ASSOC);

            mysqli_free_result($result);
            //mysqli_free_result($result_seat);
    }
    mysqli_close($link);
    	}
    }
    else
    {
        print "Включите куки, и повторите снова";
    }
    ?>
    <form method = 'POST' action = 'order.php'>
    <?php 
            echo "<p>Номер выбранного рейса <input size='10' type='text' name='selected_race' 
            value='$selected_race' readonly></p>";
            echo "<p>Выберите класс места</p>";
            echo "<p><input type='checkbox' name='seat_type[]' value='Стандартный' checked> Стандартный класс</p>";
            if (intval($line['business_volume'])>0)
                echo "<input type='checkbox' name='seat_type[]' value='Бизнес' readonly> Бизнес класс</p>";
            if (intval($line['first_volume'])>0)
                echo "<input type='checkbox' name='seat_type[]' value='Первый' readonly> Первый класс</p>";
    ?>
    <p>Номер места* <input type='text' name='seat_number' value='' required></p>
    <p>Фамилия* <input type='text' name='ticket_surname' value='' required></p>
    <p>Имя* <input type='text' name='ticket_name' value='' required></p>
    <p>Отчество <input type='text' name='ticket_patronymic' value=''></p>
    <p>Дата рождения <input type='date' name='ticket_birth_date' value='' required></p>
    <p>Серия и номер пасспорта
    <input type='text' name='ticket_passport' value='' required></p>
    <p><input name='submit_selected_race' type='submit' value='Приобрести билет'></p>
    <a href="http://air/races/">Назад</a>
            </div>
        </div>
 </body>
</html>