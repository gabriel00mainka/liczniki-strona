<?php
// exec('cd /home/pi/programy');
// shell_exec('sudo chmod 777 check.py');
// shell_exec('python3 check.py');
// echo"udalo sie";
// exit; 

$command = escapeshellcmd('/home/pi/programy/check.py');
shell_exec("sudo chmod +x check.py");
$output = shell_exec($command);
// echo $output;

exit; 