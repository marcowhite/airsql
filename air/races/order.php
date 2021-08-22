<?php
// Соединямся с БД
$race=htmlentities($_POST['selected_race']);
$link=mysqli_connect("localhost", "mysql", "123", "airsql");
if(isset($_POST['submit_selected_race']))
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
            return FALSE;
        }
        else
        {
    	    	if (!empty($_POST['seat_type']) and count($_POST['seat_type'])<2)
                {
                foreach ($_POST['seat_type'] as $col_value) 
                    {
                        if ($col_value=='Первый')
                            $selected_class="F";
                        if ($col_value=='Стандартный')
                            $selected_class="S";
                        if ($col_value=='Бизнес')
                            $selected_class="B";
                    }
                $query = mysqli_query($link, "SELECT * FROM tickets WHERE seat_type = '".mysqli_real_escape_string($link,$selected_class)."' AND seat_number =
                '".mysqli_real_escape_string($link,$_POST['seat_number'])."' AND race_id = '".$race."'  LIMIT 1");
                if (mysqli_num_rows($query) <= 0)
                {
                    $query =
                    "INSERT INTO `tickets`(`race_id`, `user_id`, `seat_type`, `seat_number`, `ticket_name`, `ticket_surname`, `ticket_patronymic`, `ticket_birth_date`, `ticket_passport`) VALUES (
                    '".$race."',
                    '".mysqli_real_escape_string($link,$userdata['user_id'])."',
                    '".mysqli_real_escape_string($link,$selected_class)."',
                    '".mysqli_real_escape_string($link,$_POST['seat_number'])."',
                    '".mysqli_real_escape_string($link,$_POST['ticket_name'])."',
                    '".mysqli_real_escape_string($link,$_POST['ticket_surname'])."',
                    '".mysqli_real_escape_string($link,$_POST['ticket_patronymic'])."',
                    '".mysqli_real_escape_string($link,$_POST['ticket_birth_date'])."',
                    '".mysqli_real_escape_string($link,$_POST['ticket_passport'])."')";
                    //echo $query;
                    //echo $selected_class;
                    $result = mysqli_query($link, $query) or die('Запрос не удался: ' . mysqli_error());
                    header("Location: http://air/profile/"); exit();
                }
                else
                {
                    echo "Место занято, вернитесь к прошлой странице";
                }
                }
    	}
    }
    else
    {
        print "Включите куки, и повторите снова";
    }
}
?>
