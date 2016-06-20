<?php

require_once "php/init.php";

$rootpath = 'structure/';
$pathnames = getListOfPathNamesOfDirectory($rootpath);

echo count($pathnames);

$search = "link98754";
$fileName = "list.csv";
$csv = fopen($fileName, "w");


//echo "<br/>" . mb_detect_encoding('”Motte”');

foreach($pathnames as $key=>$path){

        $file = $path;

        $link = deleteAndGetLineFromFile ($file, $search);
        $sub_link = explode("link98754-", $link);
        $link =  $sub_link[count($sub_link)-1];

        $xml = null;

        if (file_exists($file)) {

            $xml = simplexml_load_file($file);
            //arrayToString($xml);

        } else {
            exit('Failed to open '. $file);
        }

        simpleXmlSearch($xml);

        $count = countWordsInfile("data.txt");
        $handle = fopen ("data.txt", "w+");
        fclose($handle);
        $file = str_replace('\\', ',',  $file);git 
        $line = "";
        $line .= $count . ",";
        $line .= $file . ",\n";


        fwrite($csv, $line);
}
fclose($csv);

//arrayToString($pathnames);
