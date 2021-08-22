    <?php
        $link = mysqli_connect("127.0.0.1", "mysql", "123", "airsql");

        if (mysqli_connect_errno()) {
            printf("Не удалось подключиться: %s\n", mysqli_connect_error());
            exit();
        }
        if(isset($_POST['submit']))
        {
        //echo mysqli_real_escape_string($link,$_POST['IATA_from']);

        //. AND 'IATA_from' = ".mysqli_real_escape_string($link,$_POST['IATA_from'])."";.
        if($_POST['IATA_from']!=='')
        {
            $IATA_from ="AND (IATA_from = '".mysqli_real_escape_string($link,$_POST['IATA_from'])."')";
        }
        else
        {
            $IATA_from ="";
        }
        if($_POST['IATA_to']!=='')
        {
            $IATA_to ="AND (IATA_to = '".mysqli_real_escape_string($link,$_POST['IATA_to'])."')";
        }
        else
        {
            $IATA_to ="";
        }
        if($_POST['date_from_date']!=='')
        {
            if ($_POST['date_from_time']!=='')
            {
                $date ="AND (date_from >= '".mysqli_real_escape_string($link,$_POST['date_from_date'])." ".mysqli_real_escape_string($link,$_POST['date_from_time'])."')";
            }
            else
                $date ="AND (date_from >= '".mysqli_real_escape_string($link,$_POST['date_from_date'])." 00:00:00')";
        }
        //".mysqli_real_escape_string($link,$_POST['date_from_date'])." ".mysqli_real_escape_string($link,$_POST['date_from_time'])."".$date."
        else
        {
            $date ="";
        }
        $query = "SELECT * FROM races WHERE (date_from >= CURRENT_TIMESTAMP) ".$date.$IATA_from.$IATA_to;
        $result = mysqli_query($link, $query) or die('Запрос не удался: ' . mysqli_error());
        mysqli_close($link);
        }
        else
        {
        //header("Location: http://air/races/");
        }
    ?>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Поиск</title>
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
        if(isset($result))
        {
        if(mysqli_num_rows($result) > 0)
        {
                echo "<table>\n";
                echo "\t<tr>\n
                        \t\t<td>Номер рейса </td>\n
                        \t\t<td>Тип Самолета</td>\n
                        \t\t<td>IATA отправления </td>\n
                        \t\t<td>IATA прибытия </td>\n
                        \t\t<td>Дата отправления </td>\n
                        \t\t<td>Дата прибытия </td>\n
                        \t\t<td>Выбрать рейс </td>\n
                        \t</tr>\n
                    ";
                while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
                {
                    echo "\t<tr>\n";
                    foreach ($line as $col_value) {
                        if($col_value==$line['race_id'])
                        {
                            echo "\t\t<form method='POST' action='selected_race.php'><td><input size='10' type='text' name='race_input' value='$col_value' readonly></td>\n";
                        }
                        else
                        {
                            echo "\t\t<td>$col_value</td>\n";
                        }
                    }
                    echo "<td>
                    <input name='submit' type='submit' value='Приобрести билет'>
                    </td></form>";
                    echo "\t</tr>\n";
                }
                echo "</table>\n";
                echo "<p>".$query."</p>";
        mysqli_free_result($result);
        }
        else
        {
            echo '<p>Ничего не найдено</p>';
        }
        }
        ?>
    <a href="http://air/">Назад</a>
                </form>
             </div>
        </div>
 </body>
</html>