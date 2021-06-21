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
<div id="zegar"></div>
<table width="800" align="center" border="1" bordercolor="#8a8a8a"  cellpadding="0" cellspacing="0">
	<tr>
    <?php
    $zapytanie1 = "SELECT * FROM status_program ORDER BY date_time DESC LIMIT 1";
    $rezultat = mysqli_query($polaczenie, $zapytanie1);
    $ile = mysqli_num_rows($rezultat);
    $row = mysqli_fetch_assoc($rezultat);
    $a2 = $row['value_status'];
    // echo"$a2";
    
        if ($ile>=1) 
		{
			echo<<<END
			<td width="10" align="center" bgcolor="#d6d6d6">Lp.</td>
			<td width="20" align="center" bgcolor="#d6d6d6">data pomiaru</td>
			<td width="50" align="center" bgcolor="#d6d6d6">stan licznika [kWh]</td>
			</tr><tr>
			END;
		}

		for ($i = 1; $i <= $ile; $i++) 
		{
			$row = mysqli_fetch_assoc($rezultat);
			$a1 = $row['date_time'];
			$a2 = $row['value_status'];
			
			echo<<<END
			<td width="10" align="center" bgcolor="#ffffff">$i</td>
			<td width="20" align="center" bgcolor="#ffffff">$a1</td>
			<td width="50" align="center" bgcolor="#ffffff">$a2</td>
			</tr><tr>
			END;        
		}
        ?>
        </tr>
	</table>
    </body>
</html>