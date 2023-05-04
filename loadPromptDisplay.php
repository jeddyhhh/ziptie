<?php
session_start();
$newFontSize = $_SESSION['fontSize'];
if(isset($_GET['var2'])) {
  $_SESSION['fontSize'] = $_GET['var2'];
  $newFontSize = $_SESSION['fontSize'];
}

$selectedPrompt = $_GET['var1'];

$botOutput = file_get_contents($selectedPrompt);
echo '<textarea id="displayFullPromptText" style="font-size:'.$newFontSize.'; background-color: white;">' . $botOutput . '</textarea>';
echo '<script>
        var textarea2 = document.getElementById("displayFullPromptText");
        textarea2.scrollTop = textarea2.scrollHeight;
      </script>';
?>