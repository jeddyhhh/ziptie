<?php
$editedPrompt = $_GET['var1'];
$promptFile = $_GET['var2'];
$newPromptFilename = $_GET['var3'];

if($newPromptFilename !== ''){
    $promptFile = "prompts/$newPromptFilename";
}

$editedPrompt = urldecode($editedPrompt);
$editedPrompt = str_replace('%20', ' ', $editedPrompt);
$editedPrompt = str_replace('\'', '', $editedPrompt);

$myfile = fopen("$promptFile", "w") or die("Unable to open file!");
fwrite($myfile, $editedPrompt);
fclose($myfile);
?>