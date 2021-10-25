<?php  	
    ini_set("display_errors", 0);
    require_once "dbconnect.php";
    $polaczenie = mysqli_connect($host, $user, $password);
    mysqli_query($polaczenie, "SET CHARSET utf8");
    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    mysqli_select_db($polaczenie, $database);
    
    $zapytanie = "SELECT * FROM status_program";
    $rezultat = mysqli_query($polaczenie, $zapytanie);
    $ile = mysqli_num_rows($rezultat);
    
    $zapytanie1 = "SELECT * FROM status_program ORDER BY date_time DESC LIMIT 1";
    $rezultat = mysqli_query($polaczenie, $zapytanie1);
    $ile = mysqli_num_rows($rezultat);
    $row = mysqli_fetch_assoc($rezultat);
    $a2 = $row['value_status'];
    // echo"$a2";
    if ($a2>0)
        {
        ?>
            <!DOCTYPE html>
            <html lang=\"pl-PL\">
            <head>
            </head>
            <body>
            <div class="nav2">
            </body>
            </html>
            <?php
        }
    else
        {
            ?>
            <!DOCTYPE html>
            <html lang=\"pl-PL\">
            <head>
            </head>
            <body>
            <div class="nav1">
            </body>
            </html>
        <?php
        }
        ?>