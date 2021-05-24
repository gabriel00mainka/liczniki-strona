<?php
    if(isset($_POST['select1'])&& isset($_POST['number']))
    {
        $action1 = $_POST['select1'];
        $value = $_POST['number'];
        switch ($action1) 
        {
            case 'wykres':
                session_start();
                $_SESSION['date_start'] = $_POST['date_start'];
                $_SESSION['date_stop'] = $_POST['date_stop'];
                $_SESSION['time_start'] = $_POST['time_start'];
                $_SESSION['time_stop'] = $_POST['time_stop'];
                $_SESSION['number'] = $_POST['number'];
                header("Location: wykres.php");
                exit();
                break;
            case 'tabela':
                session_start();
                $_SESSION['date_start'] = $_POST['date_start'];
                $_SESSION['date_stop'] = $_POST['date_stop'];
                $_SESSION['time_start'] = $_POST['time_start'];
                $_SESSION['time_stop'] = $_POST['time_stop'];
                $_SESSION['number'] = $_POST['number'];
                header("Location: dane.php");
                exit();
                break;
            default:
                echo "Wróć do strony głównej i uzupełnij od nowa wszystkie opcje!</br>";
                // echo "$value";
                break;
        }
    }
?>

<!DOCTYPE html>
<html lang=\"pl-PL\">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
        <title>Błąd</title>
        <link rel="stylesheet" href="styl.css" type="text/css">
    </head>
        
    <body>
        <div class="center">
            <input type="button" style="width:200px; height:40px;" value="Powrót do strony głównej" onClick="location.href='index.html';">
        </br>
        </div>
    </body>
</html>