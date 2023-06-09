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
$altOutputName = $_GET['var22'];
$useRandomSeed = $_GET['var23'];
$mirostat_N = $_GET['var24'];
$mirostat_LR = $_GET['var25'];
$mirostat_E = $_GET['var26'];
$presPen = $_GET['var27'];
$freqPen = $_GET['var28'];
$tfs = $_GET['var29'];
$tSampling = $_GET['var30'];
$promptCacheFileName = $_GET['var31'];
$cacheAll = $_GET['var32'];
$logitBias = $_GET['var33'];
$logitBias = str_replace('%2B', '+', $logitBias);

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
    $prompt == "--random-prompt";
    $displayPrompt = "~~~Pre/User prompts ignored, random output~~~";
}

if($cacheAll == 1){
    $cacheAll = "";
} else if($cacheAll == 2){
    $cacheAll = "--prompt-cache-all";
}

// } else {
//     $prePromptContents = file_get_contents($selectedPrePrompt);
//     $fullPrompt = "$prePromptContents";
//     $fullPrompt  = htmlspecialchars($fullPrompt, ENT_QUOTES);
//     $displayPrompt = $fullPrompt;
// }

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

if($useRandomSeed == 2){
    $seedChoice = rand(1, 99999999);
}

$filename = "/var/www/html/ziptie/$outputNameAppend";
if(filesize($filename) > $outputTxtSize){
    $randomNumber = time();
    shell_exec("cp /var/www/html/ziptie/$outputNameAppend /var/www/html/ziptie/$outputNameAppend-$randomNumber.txt");
    shell_exec("rm /var/www/html/ziptie/$outputNameAppend");
}

// if(strpos(file_get_contents($selectedPrePrompt),"%~%USERPROMPT%~%") !== false) {
//     $filename = $selectedPrePrompt;
//     $eachlines = file($filename, FILE_IGNORE_NEW_LINES);
//     $fullPrompt = "";
//     foreach($eachlines as $lines){
//         $fullPrompt .= "$lines\n";
//         $fullPrompt = str_replace("%~%USERPROMPT%~%", $prompt, $fullPrompt);
//     }
//     $fullPrompt = htmlspecialchars($fullPrompt, ENT_QUOTES);
// }

$outputFileName = "$outputNameAppend";

if($disableHChoice == 1){
    $currentDate = date("F j, Y, g:i a"); 
    $fp = fopen($outputFileName, 'a');  
    fwrite($fp, "\r");
    fwrite($fp, "\nNew Generation - Model: $sMN - Tokens: $tokens - Temp: $temp - Top_k: $topk - Top_p: $topp - Context Size: $contextSize - Repeat Penalty: $repeatP - Seed: $seedChoice\n");  
    $promptFileName = basename($selectedPrePrompt);
    fwrite($fp,"Init Prompt: $promptFileName\n");
    //fwrite($fp,"User Prompt: $displayPrompt\n");
    fwrite($fp,"Date: $currentDate\n");
    fwrite($fp, "\r\n");
    fclose($fp);
}

if($altOutputName !== ''){
    $altOutputName = "| tee /var/www/html/ziptie/$altOutputName";
}

$prompt  = htmlspecialchars($prompt, ENT_QUOTES);
//$prompt = "$prompt";

if($promptCacheFileName !== ''){
    $promptCacheFileName = "--prompt-cache /var/www/html/ziptie/promptCache/$promptCacheFileName";
} else {
    $promptCacheFileName = '';
}

if($logitBias !== ''){
    $logitBiasString = '';
    $logitArray = explode(',', $logitBias);
    foreach ($logitArray as $value) {
        $logitBiasString = "$logitBiasString --logit-bias $value";
    }
}

error_log($logitBias);

chdir('/var/www/html/ziptie/llama.cpp');
error_log("./main -m $selectedModel $selectedRamChoice $cacheAll $promptCacheFileName $logitBiasString --keep $keepChoice --mirostat $mirostat_N --mirostat_lr $mirostat_LR --mirostat_ent $mirostat_E --presence_penalty $presPen --frequency_penalty $freqPen --tfs $tfs --typical $tSampling --seed $seedChoice $threadChoice -n $tokens -c $contextSize --top_k $topk $selectedEos --top_p $topp -p '$prompt' --repeat_penalty $repeatP --repeat_last_n $lastNPChoice --temp $temp $selectedTimestamp $altOutputName | tee -a /var/www/html/ziptie/$outputFileName 2>&1");
shell_exec("./main -m $selectedModel $selectedRamChoice $cacheAll $promptCacheFileName $logitBiasString --keep $keepChoice --mirostat $mirostat_N --mirostat_lr $mirostat_LR --mirostat_ent $mirostat_E --presence_penalty $presPen --frequency_penalty $freqPen --tfs $tfs --typical $tSampling --seed $seedChoice $threadChoice -n $tokens -c $contextSize --top_k $topk $selectedEos --top_p $topp -p '$prompt' --repeat_penalty $repeatP --repeat_last_n $lastNPChoice --temp $temp $selectedTimestamp $altOutputName | tee -a /var/www/html/ziptie/$outputFileName 2>&1");
?>