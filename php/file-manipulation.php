<?php
function csv_to_array($filename='', $delimiter=',')
{
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
}

function loadXML($fileName){
    if (file_exists($fileName)) {
        $xml = simplexml_load_file($fileName);

        return $xml;
    } else {
        exit('Failed to open '. $fileName);
    }
}

function dirToArray($dir) {

    $result = array();

    $cdir = scandir($dir);
    foreach ($cdir as $key => $value)
    {
        if (!in_array($value,array(".","..")))
        {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
            {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            }
            else
            {
                $result[] = $value;
            }
        }
    }

    return $result;
}

function readTxtFile($filename){

    $file = fopen($filename,"r");

    $urls = array();

    while(! feof($file))
    {
        array_push($urls, fgets($file));
    }

    fclose($file);

    return $urls;
}

function getFileNamesFromDirectory($DIR){

    $files = dirToArray($DIR);
    $fileNames = array();

    foreach($files as $value){

        $pieces = explode("~", $value);
        $fileExt = explode(".", $pieces[count($pieces)-1])[0];

        array_push($fileNames ,$fileExt);
    }
    return $fileNames;
}

function sortFilesIntoFolders($fileNames, $Structure){

    $WWW = "http~~~www~breconbeacons~org~";
    $sourceFile = "data/raw-xml/";
    $spaces = array("\n", "\r", "\t", " ");

    foreach($fileNames as $key=>$fileName){

        $destFile = findInFile($Structure, $fileName) . ".html";
        $destFile = "structure".str_replace($spaces, "",  $destFile);

        echo "<br/>".$destFile;

        $srcFile = $sourceFile . $WWW . $fileName . ".html";

        echo "<br/>".$srcFile;

        if (!copy($srcFile,$destFile)) {

            echo "<br/> failed to  copy file: ". $srcFile;
        }else{
            unlink($srcFile);
        }
    }
}

function findInFile($STRUCTURE, $searchThis){

    $match =null;
    $spaces = array("\n", "\r", "\t", " ");

    $handle = @fopen($STRUCTURE, "r");
    if ($handle)
    {
        while (!feof($handle))
        {
            $buffer = fgets($handle);

            $line = explode("/", $buffer);
            $ext = $line[count($line)-1];

            //Clean the Data
            $ext = str_replace($spaces, "",  $ext);
            $searchThis = str_replace($spaces, "",  $searchThis);

            if($searchThis===$ext){

                $match = $buffer;
            }else{

            }
        }
        fclose($handle);
    }

    return $match;
}

function getListOfPathNamesOfDirectory($DIR){

    $pathnames = array();
    $fileinfos = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($DIR)
    );
    foreach($fileinfos as $pathname => $fileinfo) {
        if (!$fileinfo->isFile()) continue;
        array_push($pathnames, $pathname);
    }

    return $pathnames;
}

function getLastLineOfFile($fileName){

    $line = '';

    $f = fopen($fileName, 'r');
    $cursor = -1;

    fseek($f, $cursor, SEEK_END);
    $char = fgetc($f);

    /**
     * Trim trailing newline chars of the file
     */
    while ($char === "\n" || $char === "\r") {
        fseek($f, $cursor--, SEEK_END);
        $char = fgetc($f);
    }

    /**
     * Read until the start of file or first newline char
     */
    while ($char !== false && $char !== "\n" && $char !== "\r") {
        /**
         * Prepend the new char
         */
        $line = $char . $line;
        fseek($f, $cursor--, SEEK_END);
        $char = fgetc($f);
    }

    return  $line;


}

function deleteAndGetLineFromFile ($fileName, $delete){

    $data = file($fileName);
    $linkFound = false;
    $out = array();
    $link= '';

    foreach($data as $line) {

        str_replace('”', '"', $line);
        
        if(strpos($line, $delete)){
            $delete = $line;
            $link = $line;
            echo "<br/>" . $line;
            $linkFound =true;
            echo "<br/>" . trim($line);
            echo "<br/>" . $delete;
        }

        if($line == $delete) {
            echo "<br/>delete";
        }else{
            $out[] = $line;
        }
    }

    $fp = fopen($fileName, "w+");
    flock($fp, LOCK_EX);
    foreach($out as $line) {
        fwrite($fp, $line);
    }
    if($linkFound==true) {
        fwrite($fp, "</body></html>");
        $linkFound=false;
    }
    flock($fp, LOCK_UN);
    fclose($fp);

    return $link;

}