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

	    $zapytanie = "SELECT * FROM msrts_15 WHERE id_d='$number' AND id_c='$rodzaj_danych' AND date_time>='$date_start $time_start' AND date_time<='$date_stop $time_stop'";
	    $rezultat = mysqli_query($polaczenie, $zapytanie);
	    $ile = mysqli_num_rows($rezultat);

		$zapytanie_2 = "SELECT latitude, longitude FROM `msrt_points` WHERE id_d='$number' ORDER BY date_time DESC LIMIT 1";
		$rezultat_2 = mysqli_query($polaczenie,$zapytanie_2);
		$row = mysqli_fetch_assoc($rezultat_2);
		$latitude = $row['latitude'];
		$longitude = $row['longitude'];
		// echo($latitude);
		// echo"</br>";
		// echo($longitude);

		$zapytanie_od = "SELECT msrt FROM `msrts_15` WHERE id_d='$number' AND id_c='$rodzaj_danych' AND date_time>='$date_start $time_start' LIMIT 1";
	    $rezultat_od = mysqli_query($polaczenie, $zapytanie_od);
	    $row_od = mysqli_fetch_assoc($rezultat_od);
		// echo($zapytanie_od);echo"</br>";
		// echo($row_od['msrt']);echo"</br>";

		$zapytanie_do = "SELECT msrt FROM `msrts_15` WHERE id_d='$number' AND id_c='$rodzaj_danych' AND date_time<='$date_stop $time_stop' ORDER BY date_time DESC LIMIT 1";
	    $rezultat_do = mysqli_query($polaczenie, $zapytanie_do);
	    $row_do = mysqli_fetch_assoc($rezultat_do);
		// echo($zapytanie_do);echo"</br>";
		// echo($row_do['msrt']);

		$dataPoints = array();
	    // $dataPoints1 = array();
	    for($i = 0; $i <= $ile; $i++)
	    {
			$a = $row['date_time'][0].$row['date_time'][1].$row['date_time'][2].$row['date_time'][3].",".$row['date_time'][5].$row['date_time'][6].",".$row['date_time'][8].$row['date_time'][9].",".$row['date_time'][11].$row['date_time'][12].",".$row['date_time'][14].$row['date_time'][15];
	    	$y = $row['msrt'];
			$time_to_label = $row['date_time'][8].$row['date_time'][9]."/".$row['date_time'][5].$row['date_time'][6]."/".$row['date_time'][2].$row['date_time'][3]." ".$row['date_time'][11].$row['date_time'][12].":".$row['date_time'][14].$row['date_time'][15];
			$b = "new Date(".$a.")";
			$b = str_replace('"','',$b);
			// echo($b);
	    	// array_push($dataPoints1, array("x" => $a, "y" => $y));
			array_push($dataPoints, array("x" => "new Date(".$a.")", "y" => $y,"label" =>'\''.$time_to_label.'\''));
			
			$row = mysqli_fetch_assoc($rezultat);

			$result = $row_do['msrt']-$row_od['msrt'];
			$result = round($result/4,1);
	    }    	
?>
 
<!DOCTYPE html>
<html lang=\"pl-PL\">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"> 
    <title>Wykres</title>
	<link rel="stylesheet" href="styl.css" type="text/css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="timer2.js"></script>
	<script>
		window.onload = function ()
		{
		var chart = new CanvasJS.Chart("chartContainer", {
			theme: "light2", // "light1", "light2", "dark1", "dark2"
			animationEnabled: true,
			zoomEnabled: true,
			title: {
				text: "Zużycie energii"
			},
			axisX:{
			title: "Data pomiaru",
			gridDashType: "timeline",
			valueFormatString: "YYYY-MM-DD"
			},
			axisY:{
			title: "Zużycie [kWh]",
			<?php
			if($rodzaj_danych>0) 
			{
			?>
				interval: 0.01
			<?php
			}
			else
			{
			?>
				
				interval: <?php print($result); ?>
			<?php
			}
			?>
			},
			data: [{
				type: "area",     
				dataPoints: <?php 
				// $dataPoints = str_replace("","",$dataPoints);
				// $dataPoints = print(str_replace('"x"','x', json_encode(array_slice($dataPoints,1), JSON_NUMERIC_CHECK)));
				echo str_replace('"','', json_encode(array_slice($dataPoints,1), JSON_NUMERIC_CHECK)); ?>
				// dataPoints: JSON.parse('<?php //echo json_encode($dataPoints, true); ?>')
			}]
			});
			chart.render();
		}
	</script>
</head>
    
<body>
<div id="div_refresh"></div>
</br>

<input type="button" value="Powrót do strony głównej" onClick="location.href='index.php';"></br></br>


<div class="center">
	<div class="white">
		Aby zobaczyć pomiary przedstawione w tabeli, naciśnij poniższy przycisk.</br></br>
		<input type="button" value="Zobacz tabelę" onClick="location.href='dane.php';"></br>
	</div>
</div>

</br>
<div class="content"> 
	<div class="white">
		<?php
		echo "Wykres zużycia energii elektrycznej z licznika numer " .$number."</br></br>";
		?>
	</div>
	<div id="chartContainer" style="height: 370px; width: 100%;"></div>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	</br>

	<iframe
		width="100%"
		height="450"
		style="border:0"
		loading="lazy"
		allowfullscreen
		src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAvhyX816GL1E1wa_78eahMLt-EmqMChmI
			&q=<?php print $latitude; ?>+<?php print $longitude; ?>">
	</iframe>
</div>
	</br>
</body>
</html>
