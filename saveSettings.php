<?php
$prompt = $_GET['var1'];
$tokens = $_GET['var2'];
$temp = $_GET['var3'];
$topk = $_GET['var4'];
$topp = $_GET['var5'];
$selectedPrePrompt = $_GET['var6'];
$selectedModel = $_GET['var7'];
$contextSize = $_GET['var8'];
$repeatP = $_GET['var9'];
$ramChoice = $_GET['var10'];
$eosChoice = $_GET['var11'];
$timestamp = $_GET['var12'];
$keepChoice = $_GET['var13'];
$lastNPChoice = $_GET['var14'];
$seedChoice = $_GET['var15'];
$randomPrompt = $_GET['var16'];
$tChoice = $_GET['var17'];
$outputTxtSize = $_GET['var18'];
$prefPrompt = $_GET['var19'];
$backgroundImage = $_GET['var20'];
$fontSize = $_GET['var21'];
$fontType = $_GET['var22'];
$alChoice = $_GET['var23'];
$outputNameAppend = $_GET['var24'];
$saveName = $_GET['var25'];
$saveAsMode = $_GET['var26'];
$disableHChoice = $_GET['var27'];
$altOutputName = $_GET['var28'];
$useRandomSeed = $_GET['var29'];
$mirostat_N = $_GET['var30'];
$mirostat_LR = $_GET['var31'];
$mirostat_E = $_GET['var32'];

if($outputNameAppend == ""){
    $temp2 = str_replace('settings-', '', $saveName);
    $outputNameAppend = "output-$temp2";
}

if($saveAsMode == 2){
    // load the data and delete the line from the array 
    $lines = file('/var/www/html/ziptie/adminSettings.txt'); 
    $last = sizeof($lines) - 1 ; 
    unset($lines[$last]); 

    // write the new data to the file 
    $fp = fopen('/var/www/html/ziptie/adminSettings.txt', 'w'); 
    fwrite($fp, implode('', $lines)); 
    fwrite($fp, "AUTOLOAD=$saveName\n");
    fclose($fp); 
}

$url = urldecode($prompt);
$prompt = str_replace('%20', ' ', $url);
$prompt = str_replace('\'', '', $prompt);

$prefPromptUrl = urldecode($prefPrompt);
$prefPrompt = str_replace('%20', ' ', $prefPrompt);
$prefPrompt = str_replace('\'', '', $prefPrompt);

//saves settings to settings-"something".txt
$myfile = fopen("/var/www/html/ziptie/$saveName", "w") or die("Unable to open file!");
fwrite($myfile, "$prompt\n");
fwrite($myfile, "$tokens\n");
fwrite($myfile, "$temp\n");
fwrite($myfile, "$topk\n");
fwrite($myfile, "$topp\n");
fwrite($myfile, "$selectedPrePrompt\n");
fwrite($myfile, "$selectedModel\n");
fwrite($myfile, "$contextSize\n");
fwrite($myfile, "$repeatP\n");
fwrite($myfile, "$ramChoice\n");
fwrite($myfile, "$eosChoice\n");
fwrite($myfile, "$timestamp\n");
fwrite($myfile, "$keepChoice\n");
fwrite($myfile, "$lastNPChoice\n");
fwrite($myfile, "$seedChoice\n");
fwrite($myfile, "$randomPrompt\n");
fwrite($myfile, "$tChoice\n");
fwrite($myfile, "$outputTxtSize\n");
fwrite($myfile, "$prefPrompt\n");
fwrite($myfile, "$backgroundImage\n");
fwrite($myfile, "$fontSize\n");
fwrite($myfile, "$fontType\n");
fwrite($myfile, "$alChoice\n");
fwrite($myfile, "$outputNameAppend\n");
fwrite($myfile, "$disableHChoice\n");
fwrite($myfile, "$altOutputName\n");
fwrite($myfile, "$useRandomSeed\n");
fwrite($myfile, "$mirostat_N\n");
fwrite($myfile, "$mirostat_LR\n");
fwrite($myfile, "$mirostat_E\n");
fclose($myfile);

//save text
$temp3 = str_replace('settings-', '', $saveName);
$outputName = "output-$temp3";
$myfile2 = fopen("/var/www/html/ziptie/$outputName", "a") or die("Unable to open file!");
fwrite($myfile2, "$saveName Saved!\n");
fclose($myfile2);
?>