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
		// $a = $row['date_time'];
		// echo($a);
	    $dataPoints = array();
	    for($i = 0; $i <= $ile; $i++)
	    {
			$a = (int)$row['date_time'];
	    	$y = $row['msrt'];
			// echo($a);
	    	array_push($dataPoints, array("x" => $i, "y" => $y));
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
			title: "Numer pomiaru",
			gridDashType: "timeline",
			gridThickness: 1
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
				dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
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
</ol>
<div class="center">
	<div class="white">
		Aby zobaczyć pomiary przedstawione w tabeli, naciśnij poniższy przycisk.</br></br>
		<input type="button" value="Zobacz tabelę" onClick="location.href='dane.php';"></br></br>
	</div>
</div>

</br></br>
<div class="content"> 
<div class="white">
<?php
echo "Wykres zużycia energii elektrycznej z licznika numer " .$number."</br></br>";
?>
</div>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
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