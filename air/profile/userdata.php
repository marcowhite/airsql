<?
// Скрипт загрузки данных
// Соединямся с БД
$link=mysqli_connect("localhost", "mysql", "123", "airsql");

if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
    $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);
}
else
{
    print "Включите куки";
}
?>