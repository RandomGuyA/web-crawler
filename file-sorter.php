<?php

include "php/init.php";

$STRUCTURE = "data/folder-structure.txt";
$FOLDER = "data/";
$DIR = $FOLDER . "raw-xml";

$files= getFileNamesFromDirectory($DIR);
sortFilesIntoFolders($files, $STRUCTURE);

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


