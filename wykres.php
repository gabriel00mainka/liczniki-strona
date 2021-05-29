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

	    $zapytanie = "SELECT * FROM msrts_15 WHERE id_d='$number' AND id_c=0 AND date_time>='$date_start $time_start' AND date_time<='$date_stop $time_stop'";
	    $rezultat = mysqli_query($polaczenie, $zapytanie);
	    $ile = mysqli_num_rows($rezultat);

	    $dataPoints = array();
	//echo "$row['date']</br>";
	    for($i = 0; $i <= $ile; $i++)
	    {
	    	$y = $row['msrt'];
	    	array_push($dataPoints, array("x" => $i, "y" => $y));
		$row = mysqli_fetch_assoc($rezultat);
	    }    	
?>

<!DOCTYPE html>
<html lang=\"pl-PL\">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"> 
    <title>Wykres</title>
	<link rel="stylesheet" href="style.css" type="text/css">
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
			gridDashType: "line",
			gridThickness: 1
			},
			axisY:{
			title: "Zużycie [kWh]",
			interval: 1
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
<input type="button" value="Zobacz tabelę" onClick="location.href='dane.php';"></br></br>
<input type="button" value="Powrót do strony głównej" onClick="location.href='index.php';"></br></br>

<!-- <form action="" method="POST">
Ustaw intrewał osi Y: 
<input type="text" name="axis_y" value="<?php isset($_POST['axis_y']) ? htmlspecialchars($_POST['axis_y']) : '' ?>" />
<input type="submit" name="submit" value="Zatwierdź"/>
</form>
<?php
// if(isset($_POST['submit'])) 
// {
//   echo 'Skok na Y jest: ', htmlspecialchars($_POST['axis_y']);
// }
?> 
-->
</br></br>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>
</html>
