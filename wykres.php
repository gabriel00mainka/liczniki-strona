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

		// $a = $row['date_time'];
		// echo($a);
		$dataPoints = array();
	    $dataPoints1 = array();
	    for($i = 0; $i <= $ile; $i++)
	    {
			$a = $row['date_time'][0].$row['date_time'][1].$row['date_time'][2].$row['date_time'][3].",".$row['date_time'][5].$row['date_time'][6].",".$row['date_time'][8].$row['date_time'][9].",".$row['date_time'][11].$row['date_time'][12].",".$row['date_time'][14].$row['date_time'][15];
	    	$y = $row['msrt'];
			
			$b = "new Date(".$a.")";
			$b = str_replace('"','',$b);
			// echo($b);
	    	array_push($dataPoints1, array("x" => $a, "y" => $y));
			array_push($dataPoints, array("x" => "new Date(".$a.")", "y" => $y));
			
			$row = mysqli_fetch_assoc($rezultat);
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
				interval: 5
			<?php
			}
			?>
			},
			data: [{
				type: "area",     
				dataPoints: <?php echo str_replace('"','', json_encode(array_slice($dataPoints,1), JSON_NUMERIC_CHECK)); ?>
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
<ol>
<input type="button" value="Powrót do strony głównej" onClick="location.href='index.php';"></br></br>


<div class="center">
	<div class="white">
		Aby zobaczyć pomiary przedstawione w tabeli, naciśnij poniższy przycisk.</br></br>
		<input type="button" value="Zobacz tabelę" onClick="location.href='dane.php';"></br></br>
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
	<!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2506.3252580173244!2d17.02226613576984!3d51.084004602730104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTHCsDA1JzAzLjkiTiAxN8KwMDEnMTYuOCJF!5e0!3m2!1spl!2spl!4v1633978519867!5m2!1spl!2spl" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->

	<iframe
		width="100%"
		height="450"
		style="border:0"
		loading="lazy"
		allowfullscreen
		src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAvhyX816GL1E1wa_78eahMLt-EmqMChmI
			&q=<?php print $latitude; ?>+<?php print $longitude; ?>">
	</iframe>

	<!-- <style>
		#map{
			height: 450px;
			width: 100%;
		}
	</style>
	<div id="map"></div>
	<script>
		var map;
		function initMap(){
			var mapPoint = {lat: 51.083742, lng: 17.022408};
			map = new google.maps.Map(document.getElementById('map'),{
				center: mapPoint,
				zoom: 15
			});
			var marker = new google.maps.Marker({position: mapPoint, map: map})
		}
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvhyX816GL1E1wa_78eahMLt-EmqMChmI
				&callback=initMap" async defer></script> -->
</div>

</body>
</html>

<!-- <!DOCTYPE HTML>
<html>
<head>  
<script type="text/javascript">
window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: "Simple Date-Time Chart"
    },
    axisX:{
        title: "time",
		valueFormatString: "DD-MMM-YY hh:mm:ss",
        gridThickness: 2
    },
    axisY: {
        title: "Downloads"
    },
    data: [
    {        
        type: "area",
        dataPoints: [//array
        { x: new Date(2021, 04, 1), y: 26},
        { x: new Date(2021, 04, 3), y: 38},
        { x: new Date(2021, 04, 5), y: 43},
        { x: new Date(2021, 04, 7), y: 29},
        { x: new Date(2021, 04, 11), y: 41},
        { x: new Date(2021, 04, 13), y: 54},
        { x: new Date(2021, 04, 20), y: 66},
        { x: new Date(2021, 04, 21), y: 60},
        { x: new Date(2021, 04, 25), y: 53},
        { x: new Date(2021, 04, 27), y: 60},
		{ x: new Date(2021,05,24,15,27,00), y: 60}
		// 2021-05-24 15:27:00
		 
        ]
    }
    ]
});

    chart.render();
}
</script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</head>
<body>
<div id="chartContainer" style="height: 300px; width: 100%;"> </div>
</body>
</html> -->