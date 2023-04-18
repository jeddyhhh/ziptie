<?php
  $path = './'; 
  $files = glob($path.'/settings*');
  shell_exec("rm /var/www/html/ziptie/avaliableSettings.txt");

  foreach(array_reverse($files) as $value) {
    $value = substr($value, 3);
    $myfile = fopen("/var/www/html/ziptie/avaliableSettings.txt", "a") or die("Unable to open file!");
    fwrite($myfile, "$value\n");
    fclose($myfile);
  }
?>