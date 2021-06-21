<?php
// if(isset($_POST['run']))
// {
// shell_exec("cd /home/pi/programy");
// shell_exec("python3 /home/pi/programy/check.py");
// }
exec('cd /var/www/html/liczniki');
shell_exec('sudo chmod 777 check.py');
shell_exec('python3 check.py');
// echo"udalo sie";
// exit; 

// $command = escapeshellcmd('/home/pi/programy/check.py');
// shell_exec("sudo chmod +x check.py");
// $output = shell_exec($command);
// echo $output;
header("Location: index.php");
// exit; 
?>