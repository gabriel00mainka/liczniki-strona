<?php 
// Include the database config file 
ini_set("display_errors", 0);
require_once "dbconnect.php";
$polaczenie = mysqli_connect($host, $user, $password);
mysqli_query($polaczenie, "SET CHARSET utf8");
mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
mysqli_select_db($polaczenie, $database);

// Filter the excel data 
function filterData(&$str)
{ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
} 
 
// Excel file name for download xls
$fileName = "export_data.xls"; 
 
// Column names 
$fields = array('Date, time', 'id_d', 'measurement'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Get records from the database 
$zapytanie1 = "SELECT * FROM msrts_15 WHERE id_c=0 ORDER BY date_time"; 
$rezultat = mysqli_query($polaczenie, $zapytanie1);
$ile = mysqli_num_rows($rezultat);

if($ile>=1)
{ 
    // Output each row of the data 
    $i=0; 
    while($row = mysqli_fetch_assoc($rezultat))
	{ 	$i++; 
        $rowData = array($row['date_time'],$row['id_d'],number_format($row['msrt'], 2, ',', '')); 
        array_walk($rowData, 'filterData'); 
		// $excelData->getActiveSheet()->getColumnDimension('A')->setWidth(true);
        $excelData .= implode("\t" ,array_values($rowData))."\n";
		// $excelData->autoFitRow(0);
		

    } 
}else
{ 
    $excelData .= 'No records found...'. "\n"; 
} 
 
// Headers for download 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
header("Content-Type: application/vnd.ms-excel"); 
 
// Render excel data 
echo $excelData; 
 
exit;