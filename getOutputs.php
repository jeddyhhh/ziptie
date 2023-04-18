<?php
  $path = './'; 
  $files = glob($path.'/output*');
  shell_exec("rm /var/www/html/ziptie/avaliableOutputs.txt");

  foreach(array_reverse($files) as $value) {
    $value = substr($value, 3);
    $myfile = fopen("/var/www/html/ziptie/avaliableOutputs.txt", "a") or die("Unable to open file!");
    fwrite($myfile, "$value\n");
    fclose($myfile);
  }
?>