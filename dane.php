<?php
    ini_set("display_errors", 0);
    require_once "dbconnect.php";
    $polaczenie = mysqli_connect($host, $user, $password);
    mysqli_query($polaczenie, "SET CHARSET utf8");
    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    mysqli_select_db($polaczenie, $database);
      
    session_start();
    $date_start = $_SESSION['date_start'];
    $date_stop = $_SESSION['date_stop'];
    $time_start = $_SESSION['time_start'];
    $time_stop = $_SESSION['time_stop'];
    $number = $_SESSION['number'];
    $rodzaj_danych = $_SESSION['rodzaj_danych'];

    $zapytanie = "SELECT * FROM msrts_15";
    $rezultat = mysqli_query($polaczenie, $zapytanie);
    $ile = mysqli_num_rows($rezultat);            
?>

<!DOCTYPE html>
<html lang=\"pl-PL\">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"> 
    <title>Wyswietlanie w tabeli</title>
    <link rel="stylesheet" href="styl.css" type="text/css">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="timer2.js"></script>
</head>
    
<body onload="odliczanie();">
    <div id="div_refresh"></div>
    <div class="center">
        <div class="white">
            <div id="zegar"></div>
        </div>
    </div>
    <input type="button" value="Powrót do strony głównej" onClick="location.href='index.php';">
    <div class="center">
        <div class="white">
            </br>
            Aby zobaczyć pomiary przedstawione na wykresie, naciśnij poniższy przycisk.</br></br>
            <input type="button" value="Zobacz wykres" onClick="location.href='wykres.php';"></br></br>
        </div>
    </div>
    <div class="content">    
        <table width="auto" align="center" border="1" bordercolor="#7b7fbd"  cellpadding="0" cellspacing="0">
            <tr>
            <?php  
                $zapytanie1 = "SELECT * FROM msrts_15 WHERE id_d='$number' AND id_c='$rodzaj_danych' AND date_time>='$date_start $time_start' AND date_time<='$date_stop $time_stop' ORDER BY date_time DESC";
                $zapytanie2 = "SELECT * FROM msrts_15 WHERE id_d='$number' AND id_c=0 ORDER BY date_time DESC LIMIT 1";
                // echo"$zapytanie1";
                // echo "$number";
                $rezultat = mysqli_query($polaczenie, $zapytanie1);
                $rezultat2 = mysqli_query($polaczenie, $zapytanie2);
                
                $ile = mysqli_num_rows($rezultat);
                // $ile2 = mysqli_num_rows($rezultat2);

                $row = mysqli_fetch_assoc($rezultat2);
                $a2 = $row['msrt'];

                echo'<div class="white">';
                    exec('cd /var/www/html/liczniki');
                    shell_exec('sudo chmod 777 read_metter_now.py');
                    $a = shell_exec('python3 read_metter_now.py');

                    echo "Pomiary wyświetlane z licznika numer ".$number."</br>";
                    echo'Aktualny stan licznika wynosi: '.$a;
                    echo'<input type="button" value="Zczytaj aktualny stan licznika" onClick="window.location.reload()"></br>';
                    echo "Najnowszy pomiar: ".$a2."</br>";
                    echo "Ilość pomiarów w bazie w zadanym przedziale czasowym: ".$ile;
                echo "</div>";   
            ?>
        </div>
        <div class="black">
            <?php
                if ($ile>=1) 
                {
                    echo<<<END
                    <td width="100" align="center" bgcolor="#d6d6d6">Lp.</td>
                    <td width="500" align="center" bgcolor="#d6d6d6">data pomiaru</td>
                    <td width="400" align="center" bgcolor="#d6d6d6">stan licznika [kWh]</td>
                    </tr><tr>
                    END;
                }

                for ($i = 1; $i <= $ile; $i++) 
                {
                    $row = mysqli_fetch_assoc($rezultat);
                    $a1 = $row['date_time'];
                    $a2 = $row['msrt'];
                    
                    echo<<<END
                    <td align="center" bgcolor="#ffffff">$i</td>
                    <td align="center" bgcolor="#ffffff">$a1</td>
                    <td align="center" bgcolor="#ffffff">$a2</td>
                    </tr><tr>
                    END;        
                }
                echo"</br>";

            ?>
            </tr>
        </div>
        </table>
    </br>
</body>
</html>