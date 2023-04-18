<?php
session_start();
$newFontSize = $_SESSION['fontSize'];
if(isset($_GET['var2'])) {
  $_SESSION['fontSize'] = $_GET['var2'];
  $newFontSize = $_SESSION['fontSize'];
}

if($_GET['var1'] == ''){
  $outputName = "output-default.txt";
} else {
  $outputName = $_GET['var1'];
}

$botOutput = file_get_contents($outputName);
echo '<textarea id="botOutputText" style="font-size:'.$newFontSize.'; background-color: white;">' . $botOutput . '</textarea>';
echo '<script>
        var textarea = document.getElementById("botOutputText");
        textarea.scrollTop = textarea.scrollHeight;
      </script>';
?>