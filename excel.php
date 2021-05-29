<?php 
    // Include the database config file 
    ini_set("display_errors", 0);
    require_once "dbconnect.php";
    $polaczenie = mysqli_connect($host, $user, $password);
    mysqli_query($polaczenie, "SET CHARSET utf8");
    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    mysqli_select_db($polaczenie, $database);

    session_start();
    $select2 = $_SESSION['select2'];
    $date_start1 = $_SESSION['date_start1'];
    $date_stop1 = $_SESSION['date_stop1'];
    $time_start1 = $_SESSION['time_start1'];
    $time_stop1 = $_SESSION['time_stop1'];
    // $number = $_SESSION['number'];
    if($select2=='wszystkie')
    {$select2='(id_d=1 OR id_d=2 OR id_d=3 OR id_d=4 OR id_d=5)';}
    else
    {$select2='id_d='; $select2 .= $_SESSION['select2'];}
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
    $zapytanie1 = "SELECT * FROM msrts_15 WHERE $select2 AND id_c=0 AND date_time>='$date_start1 $time_start1' AND date_time<='$date_stop1 $time_stop1' ORDER BY date_time"; 
    $rezultat = mysqli_query($polaczenie, $zapytanie1);
    $ile = mysqli_num_rows($rezultat);
    // echo($zapytanie1);
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