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
$outputNameAppend = $_GET['var20'];
$disableHChoice = $_GET['var21'];

$url = urldecode($prompt);
$prompt = str_replace('%20', ' ', $url);
$prompt = str_replace('\'', '', $prompt);

$prefPromptUrl = urldecode($prefPrompt);
$prefPrompt = str_replace('%20', ' ', $prefPrompt);
$prefPrompt = str_replace('\'', '', $prefPrompt);

$sMN = str_replace("/var/www/html/ziptie/llama.cpp/models/", "", "$selectedModel");
$sMN = explode("/", $sMN);
$sMN = $sMN[0];

if($ramChoice == 1){
    $selectedRamChoice = "";
} else if($ramChoice == 2){
    $selectedRamChoice = "--mlock";
}

if($eosChoice == 1){
    $selectedEos = "";
} else if($eosChoice == 2){
    $selectedEos = "--ignore-eos";
}

if($timestamp == 1){
    $selectedTimestamp = "";
} else if($timestamp == 2){
    $selectedTimestamp = "| awk '{ print strftime(\"%H:%M:%S\"), $0; fflush(); }\'";
}

if($randomPrompt == 2){
    $fullPrompt == "--random-prompt";
    $displayPrompt = "~~~Pre/User prompts ignored, random output~~~";
} else {
    $prePromptContents = file_get_contents($selectedPrePrompt);
    $fullPrompt = "$prePromptContents $prompt";
    $fullPrompt  = htmlspecialchars($fullPrompt, ENT_QUOTES);
    $displayPrompt = $prompt;
}

if($tChoice > 0){
    $threadChoice = "--threads $tChoice";
} else {
    $threadChoice = "";
}

if($prefPrompt != ''){
    $selectedPrefPrompt = "--in-prefix '$prefPrompt'";
} else {
    $selectedPrefPrompt = '';
}

$filename = "/var/www/html/ziptie/$outputNameAppend";
if(filesize($filename) > $outputTxtSize){
    $randomNumber = time();
    shell_exec("cp /var/www/html/ziptie/$outputNameAppend /var/www/html/ziptie/output-$outputNameAppend-$randomNumber.txt");
    shell_exec("rm /var/www/html/ziptie/$outputNameAppend");
}

if(shell_exec("pgrep -l main") == true){
    shell_exec("sudo pkill main");
    if(shell_exec("pgrep -l main") == true){
        shell_exec("sudo pkill main");
    }
}

$outputFileName = "$outputNameAppend";

if($disableHChoice == 1){
    $currentDate = date("F j, Y, g:i a"); 
    $fp = fopen($outputFileName, 'a');  
    fwrite($fp, "\r");
    fwrite($fp, "\nNew Generation - Model: $sMN - Tokens: $tokens - Temp: $temp - Top_k: $topk - Top_p: $topp - Context Size: $contextSize - Repeat Penalty: $repeatP - Seed: $seedChoice\n");  
    $promptFileName = basename($selectedPrePrompt);
    fwrite($fp,"Init Prompt: $promptFileName\n");
    fwrite($fp,"User Prompt: $displayPrompt\n");
    fwrite($fp,"Date: $currentDate\n");
    fwrite($fp, "\r\n");
    fclose($fp);
}


chdir('/var/www/html/ziptie/llama.cpp');
shell_exec("./main -m $selectedModel $selectedRamChoice --keep $keepChoice --seed $seedChoice $threadChoice -n $tokens -c $contextSize $selectedPrefPrompt --n_parts 1 --top_k $topk $selectedEos --top_p $topp -p '$fullPrompt' --repeat_penalty $repeatP --repeat_last_n $lastNPChoice --temp $temp $selectedTimestamp | tee -a /var/www/html/ziptie/$outputFileName 2>&1");
?>