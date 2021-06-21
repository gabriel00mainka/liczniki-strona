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

    if(isset($_POST['select2']))
    {
        $action2 = $_POST['select2'];
        switch ($action2) 
        {
            case 'wszystkie':
                session_start();
                $_SESSION['select2'] = $_POST['select2'];
                $_SESSION['date_start1'] = $_POST['date_start1'];
                $_SESSION['date_stop1'] = $_POST['date_stop1'];
                $_SESSION['time_start1'] = $_POST['time_start1'];
                $_SESSION['time_stop1'] = $_POST['time_stop1'];
                // $_SESSION['number1'] = $_POST['number'];
                header("Location: excel.php");
                exit();
                break;
            case '1':
                session_start();
                $_SESSION['select2'] = $_POST['select2'];
                $_SESSION['date_start1'] = $_POST['date_start1'];
                $_SESSION['date_stop1'] = $_POST['date_stop1'];
                $_SESSION['time_start1'] = $_POST['time_start1'];
                $_SESSION['time_stop1'] = $_POST['time_stop1'];
                // $_SESSION['number1'] = $_POST['number'];
                header("Location: excel.php");
                exit();
                break;
            case '2':
                session_start();
                $_SESSION['select2'] = $_POST['select2'];
                $_SESSION['date_start1'] = $_POST['date_start1'];
                $_SESSION['date_stop1'] = $_POST['date_stop1'];
                $_SESSION['time_start1'] = $_POST['time_start1'];
                $_SESSION['time_stop1'] = $_POST['time_stop1'];
                // $_SESSION['number1'] = $_POST['number'];
                header("Location: excel.php");
                exit();
                break;
            case '3':
                session_start();
                $_SESSION['select2'] = $_POST['select2'];
                $_SESSION['date_start1'] = $_POST['date_start1'];
                $_SESSION['date_stop1'] = $_POST['date_stop1'];
                $_SESSION['time_start1'] = $_POST['time_start1'];
                $_SESSION['time_stop1'] = $_POST['time_stop1'];
                // $_SESSION['number1'] = $_POST['number'];
                header("Location: excel.php");
                exit();
                break;
            case '4':
                session_start();
                $_SESSION['select2'] = $_POST['select2'];
                $_SESSION['date_start1'] = $_POST['date_start1'];
                $_SESSION['date_stop1'] = $_POST['date_stop1'];
                $_SESSION['time_start1'] = $_POST['time_start1'];
                $_SESSION['time_stop1'] = $_POST['time_stop1'];
                // $_SESSION['number1'] = $_POST['number'];
                header("Location: excel.php");
                exit();
                break;
            case '5':
                session_start();
                $_SESSION['select2'] = $_POST['select2'];
                $_SESSION['date_start1'] = $_POST['date_start1'];
                $_SESSION['date_stop1'] = $_POST['date_stop1'];
                $_SESSION['time_start1'] = $_POST['time_start1'];
                $_SESSION['time_stop1'] = $_POST['time_stop1'];
                // $_SESSION['number1'] = $_POST['number'];
                header("Location: excel.php");
                exit();
                break;
            default:
                echo "Wróć do strony głównej i uzupełnij z którego licznika chcesz pobrać pomiary!</br>";
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
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
        
    <body>
        <div class="center">
            <input type="button" style="width:200px; height:40px;" value="Powrót do strony głównej" onClick="location.href='index.php';">
        </br>
        </div>
    </body>
</html>