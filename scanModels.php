<?php
$path = '/var/www/html/ziptie/llama.cpp/models';
shell_exec("rm /var/www/html/ziptie/avaliableModels.txt");

function getDirContents($path) {
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

    $files = array(); 
    foreach ($rii as $file)
        if (!$file->isDir())
            $files[] = $file->getPathname();

    return $files;
}

$modelArray = getDirContents($path);

foreach($modelArray as $modelFileName) {
    if(!str_contains($modelFileName, ':Zone.Identifier') && !str_contains($modelFileName, 'ggml-vocab.bin')){
        $modelName = str_replace("/var/www/html/ziptie/llama.cpp/models/", "", "$modelFileName");
        $modelName = explode("/", $modelName);
        $modelName = $modelName[0];
        echo "<script>console.log('$modelName --- $modelFileName')</script>";
        echo '<br>';

        $myfile = fopen("/var/www/html/ziptie/avaliableModels.txt", "a") or die("Unable to open file!");
        $txt = "$modelName~$modelFileName\n";
        fwrite($myfile, $txt);
        fclose($myfile);

        shell_exec("chmod -R 775 $modelFileName");
    }
}

?>