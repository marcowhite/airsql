<?
// Страница регистрации нового пользователя

// Соединямся с БД
$link=mysqli_connect("localhost", "mysql", "123", "airsql");

if(isset($_POST['submit']))
{
    $err = [];

    // проверям логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    if(trim($_POST['password']) != trim($_POST['password-submit']))
    {
        $err[] = "Пароли не совпадают";
    }

    // проверяем, не сущестует ли пользователя с таким именем
    $query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }

    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {

        $login = $_POST['login'];

        // Убераем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($_POST['password'])));

        mysqli_query($link,"INSERT INTO users SET user_login='".$login."', user_password='".$password."'");
        header("Location: login.php"); exit();
    }
    else
    {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
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
            <div class="field">
                <label>Логин:</label>
                <input name="login" type="text" required>
            </div>
             <div class="field">
                <label>Пароль:</label>
                <input name="password" type="password" required>
            </div>
            <div class="field">
                <label>Подтвердите пароль:</label>
                <input name="password-submit" type="password" required>
            </div>
            <!--Не прикреплять к IP(не безопасно) <input type="checkbox" name="not_attach_ip"><br> -->
            <div class="field">
                <label></label>
                <input name="submit" type="submit" value="Зарегистрироваться">
            </div>
        </form>
        <a href="http://air/profile">Назад</a>
        </div>
    </div>
</body>
</html>
