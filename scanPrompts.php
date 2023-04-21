<?php
$path = '/var/www/html/ziptie/llama.cpp/prompts';
$path2 = '/var/www/html/ziptie/prompts';
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

function getDirContents2($path2) {
    $rii2 = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path2));

    $files2 = array(); 
    foreach ($rii2 as $file2)
        if (!$file2->isDir())
            $files2[] = $file2->getPathname();

    return $files2;
}

$modelArray2 = getDirContents2($path2);

foreach($modelArray2 as $modelFileName2) {
    if(!str_contains($modelFileName2, ':Zone.Identifier')){
        $promptFullPath2 = $modelFileName2;
        $promptName2 = str_replace("/var/www/html/ziptie/prompts/", "", "$modelFileName2");
        $promptName2 = explode(".", $promptName2);
        $promptName2 = $promptName2[0];
        echo "<script>console.log('$promptName2 --- $promptFullPath2')</script>";
        echo '<br>';

        $myfile2 = fopen("/var/www/html/ziptie/avaliablePrompts.txt", "a") or die("Unable to open file!");
        $txt2 = "$promptName2~$promptFullPath2\n";
        fwrite($myfile2, $txt2);
        fclose($myfile2);
    }
}
?>