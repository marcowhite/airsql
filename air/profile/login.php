<?
// Страница авторизации

// Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

// Соединямся с БД
$link=mysqli_connect("localhost", "mysql", "123", "airsql");

if(isset($_POST['submit']))
{
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($link,"SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    // Сравниваем пароли
    if($data['user_password'] === md5(md5($_POST['password'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));
        $_POST['not_attach_ip']=1;
        if(!empty($_POST['not_attach_ip']))
        {
            // Если пользователя выбрал привязку к IP
            // Переводим IP в строку
            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
        }

        // Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");

        // Ставим куки
        setcookie("id", $data['user_id'], time()+60*60*24*30, "/");
        setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!!

        // Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: check.php"); exit();
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
}
?>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Регистрация</title>
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
            <form method="POST">
            <div class="fields">
                <div class="field">
                    <label>Логин:</label>
                    <input name="login" type="text" required>
                </div>
                 <div class="field">
                    <label>Пароль:</label>
                    <input name="password" type="password" required>
                    </div>
                <!--Не прикреплять к IP(не безопасно) <input type="checkbox" name="not_attach_ip"><br> -->
                <div class="field">
                    <label></label>
                    <input name="submit" type="submit" value="Войти">
                </div>
            </div>
            </form>
            <a href="http://air/profile">Назад</a>
        </div>
    </div>
</body>
</html>