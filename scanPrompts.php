<?php
$path = '/var/www/html/ziptie/llama.cpp/prompts';
shell_exec("rm /var/www/html/ziptie/avaliablePrompts.txt");
shell_exec("touch /var/www/html/ziptie/llama.cpp/prompts/no-pre-prompt.txt");

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
    if(!str_contains($modelFileName, ':Zone.Identifier')){
        $promptFullPath = $modelFileName;
        $promptName = str_replace("/var/www/html/ziptie/llama.cpp/prompts/", "", "$modelFileName");
        $promptName = explode(".", $promptName);
        $promptName = $promptName[0];
        echo "<script>console.log('$promptName --- $promptFullPath')</script>";
        echo '<br>';

        $myfile = fopen("/var/www/html/ziptie/avaliablePrompts.txt", "a") or die("Unable to open file!");
        $txt = "$promptName~$promptFullPath\n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }
}
?>