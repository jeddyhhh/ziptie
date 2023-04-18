<?php
$outputName = $_GET['var1'];
if(shell_exec("pgrep -l main") == true){
    shell_exec("pkill main");
    if(shell_exec("pgrep -l main") == true){
        shell_exec("pkill main");
    }
}

$fp2 = fopen($outputName, 'a');  
fwrite($fp2, "\r\n");
fwrite($fp2, "Generation Cancelled");  
fwrite($fp2, "\r\n");
fclose($fp2);
?>