<head>
    <link rel="stylesheet" href="includes/style.css">
    <script src="includes/jquery-3.6.4.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>ZIPTIE: Output Archive.</title>
</head>

<?php
  $path = './'; 
  $files = glob($path.'/output*');

  foreach(array_reverse($files) as $value) {
    $archiveOutput = file_get_contents($value);
    echo "<div id='archiveMain'>";
    echo "<div id='archiveInfoDiv'>
            <font style='font-size:20px'>$value</font>
    </div>";
    echo '<textarea id="archiveOutputText">' . $archiveOutput . '</textarea>';
    echo "</div>";
    echo '<br>';
    echo '<br>';
  }
?>