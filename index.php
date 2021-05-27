<?php
// ini_set("display_errors", 0);
// require_once "dbconnect.php";
// $polaczenie = mysqli_connect($host, $user, $password);
// mysqli_query($polaczenie, "SET CHARSET utf8");
// mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
// mysqli_select_db($polaczenie, $database);

// $zapytanie = "SELECT * FROM status_program";
// $rezultat = mysqli_query($polaczenie, $zapytanie);
// $ile = mysqli_num_rows($rezultat);
?>

<!DOCTYPE html>
<html lang=\"pl-PL\">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"> 
    <title>Wyswietlanie w tabeli</title>
    <link rel="stylesheet" href="styl.css" type="text/css">
	<!-- src="timer2.js" -->
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="timer2.js"></script>
</head>
<!-- onload="odliczanie();" -->
<body onload="odliczanie();">
<div id="div_refresh"></div>
<div class="center">
<div id="zegar"></div>
<ol>Projekt zespołowy - zdalne czytanie liczników energii elektrycznej</ol>
</div>
</br>
<div class="content">
	<div class="white">
		<p style="text-indent: 5%; ">
		Jest to strona internetowa przeznaczona do zdalnego czytania liczników. Konieczne jest uzupełnienie wszystkich pól w tabeli poniżej aby wyświetlić żądane pomiary.
		</p>
		</br></br>
		
		<table width="500" align="center" border="1" bordercolor="#999999"  cellpadding="0" cellspacing="0">
			<tr>
				<td colspan="2">Uzupełnij aby wyświetlić pomiary</td>
			</tr>
			<tr>
				<td>Numer licznika</td>
				<td>
					<form action="action.php" method="post">
						<input type="number" id="number" name="number" min="1" max="5">
				</td>
			</tr>
			<tr>
				<td>Forma prezentacji</td>
				<td>
						<select name="select1" style="width:150px; height:30px;">
							<option value="wybierz_opcje" selected>Wybierz opcje</option>
							<option name="wykres" value="wykres">Wykres</option>
							<option name="tabela" value="tabela">Tebela</option>
						</select>
				</td>
			</tr>
			<tr>
				<td>Data od</td>
				<td>
					<input type="date" id="start_date" name="date_start" value="2021-04-20" min="2021-04-01" max="2080-12-31">
				</td>
			</tr>
			<tr>
				<td>Data do</td>
				<td>
					<input type="date" id="stop_date" name="date_stop" value="2021-05-24" min="2021-03-01" max="2080-12-31">
				</td>
			</tr>
			<tr>
				<td>Czas od</td>
				<td>
					<input type="time" id="start_time" name="time_start" value="00:00" min="00:00" max="23:59" required>
				</td>
			</tr>
			<tr>
				<td>Czas do</td>
				<td>
					<input type="time" id="stop_time" name="time_stop" value="23:59" min="00:00" max="23:59" required>
				</td>
			</tr>	
			<tr>
				<td colspan="2">
					<input type="submit" name="submit" value="Zobacz pomiary" style=" background:LightGray; width:500px; height:30px;">
				</td>
			</tr>
					</form>

		</table>
	</div>
</div>
</body>
</html>
