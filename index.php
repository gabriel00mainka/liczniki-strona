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
		<b><ol>Projekt zespołowy - zdalne czytanie liczników energii elektrycznej</ol></b>
	</div>
</div>
</br>
<div class="content">
	<div class="white">
		<p style="text-indent: 5%; ">
		Jest to strona internetowa przeznaczona do zdalnego czytania liczników. Konieczne jest uzupełnienie wszystkich pól w tabeli poniżej, aby wyświetlić żądane pomiary.
		</p>
		</br>

		<table width=500 align="center" border="1" bordercolor="#7b7fbd"  cellpadding="2" cellspacing="0">
			<tr>
				<td colspan="2">Uzupełnij aby wyświetlić pomiary</td>
			</tr>
			<tr>
				<td>Numer licznika</td>
				<td>
					<form action="action.php" method="post">
						<input type="number" style="width:50px; height:22px;" id="number" name="number" min="1" max="5">
				</td>
			</tr>
			<tr>
				<td>Forma prezentacji</td>
				<td>
					<select name="select1" style="width:145px; height:30px; font-family: Arial;">
						<option value="wybierz_opcje" selected>Wybierz opcje</option>
						<option name="wykres" value="wykres">Wykres + mapa</option>
						<option name="dane" value="dane">Tabela</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Rodzaj danych</td>
				<td>
					<select name="select3" style="width:145px; height:30px;">
						<option value="wybierz_opcje" selected>Wybierz opcje</option>
						<option name="liczydlo" value="liczydlo">liczydło</option>
						<option name="profile" value="profile">profile</option>
					</select>
				</td>
			<tr>
				<td>Data od</td>
				<td>
					<input type="date" style="width:140px; height:25px;" id="start_date" name="date_start" value="2021-04-20" min="2021-04-01" max="2080-12-31">
				</td>
			</tr>
			<tr>
				<td>Data do</td>
				<td>
					<input type="date" style="width:140px; height:25px;" id="stop_date" name="date_stop" value="<?php echo date("Y-m-d") ?>" min="2021-03-01" max="2080-12-31">
				</td>
			</tr>
			<tr>
				<td>Czas od</td>
				<td>
					<input type="time" style="width:70px; height:25px;" id="start_time" name="time_start" value="00:00" min="00:00" max="23:59" required>
				</td>
			</tr>
			<tr>
				<td>Czas do</td>
				<td>
					<input type="time" style="width:70px; height:25px;" id="stop_time" name="time_stop" value="23:59" min="00:00" max="23:59" required>
				</td>
			</tr>	
			<tr>
				<td colspan="2">
					<input type="submit" name="submit" value="Zobacz pomiary" style='color:#ffffff; background:url("img/tlo_submit.jpeg"); width:500px; height:30px;'>
				</td>
			</tr>
					</form>		

		</table></br></br>
	
		<div class="center">

			<form action="action.php" method="post">
			Pobierz pomiary z licznika numer: <select name="select2" style="width:120px; height:30px;">
												<option value="wybierz_opcje" selected>Wybierz opcje</option>
												<option name="wszystkie" value="wszystkie">wszystkie</option>
												<option name="1" value="1">1</option>
												<option name="2" value="2">2</option>
												<option name="3" value="3">3</option>
												<option name="4" value="4">4</option>
												<option name="5" value="5">5</option>
												</select>
			z przedziału czasowego od: 
			<input type="date" style="width:130px; height:25px;" id="start_date1" name="date_start1" value="2021-04-20" min="2021-04-01" max="2080-12-31">
			<input type="time" style="width:70px; height:25px;" id="start_time1" name="time_start1" value="00:00" min="00:00" max="23:59" required>
			do: 
			<input type="date" style="width:130px; height:25px;" id="stop_date1" name="date_stop1" value="2021-06-22" min="2021-03-01" max="2080-12-31">
			<input type="time" style="width:70px; height:25px;" id="stop_time1" name="time_stop1" value="23:59" min="00:00" max="23:59" required>
			</br></br>
			<input type="submit" name="submit" value="Pobierz" style='color:#ffffff; background:url("img/tlo_submit.jpeg"); width:500px; height:30px;" onClick="location.href="""excel.php""";'>
			</form>
		</div>
	</div>
</div>
</br>

</body>
</html>
