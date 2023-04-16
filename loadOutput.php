<?php
session_start();
$newFontSize = $_SESSION['fontSize'];
if(isset($_GET['var1'])) {
  $fontSize = $_GET['var1'];
  $_SESSION['fontSize'] = $fontSize;
  $newFontSize = $_SESSION['fontSize'];
}

$botOutput = file_get_contents('output.txt');
echo '<textarea id="botOutputText" style="font-size:'.$newFontSize.'; background-color: white;">' . $botOutput . '</textarea>';
echo '<script>
        var textarea = document.getElementById("botOutputText");
        textarea.scrollTop = textarea.scrollHeight;
      </script>';
?>