<?php
if(shell_exec("pgrep -l main") == true){
    shell_exec("pkill main");
    if(shell_exec("pgrep -l main") == true){
        shell_exec("pkill main");
    }
}

$fp2 = fopen('output.txt', 'a');  
fwrite($fp2, "\r\n");
fwrite($fp2, "Generation Cancelled");  
fwrite($fp2, "\r\n");
fclose($fp2);
?>