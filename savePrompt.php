<?php
$editedPrompt = $_GET['var1'];
$promptFile = $_GET['var2'];

$editedPrompt = urldecode($editedPrompt);
$editedPrompt = str_replace('%20', ' ', $editedPrompt);
$editedPrompt = str_replace('\'', '', $editedPrompt);
$editedPrompt = str_replace('%3C', '<', $editedPrompt);
$editedPrompt = str_replace('%7C', '|', $editedPrompt);
$editedPrompt = str_replace('%3E', '>', $editedPrompt);

$myfile = fopen("prompts/$promptFile", "w") or die("Unable to open file!");
fwrite($myfile, $editedPrompt);
fclose($myfile);

echo "<script>console.log('savePrompt.php has run')</script>";
?>