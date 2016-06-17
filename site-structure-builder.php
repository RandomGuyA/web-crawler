<?php

include "php/init.php";

$DIR = "structure";
$FILE = "data/folder-structure.txt";

$pathNames = readTxtFile($FILE);

foreach($pathNames as $value){
    $path = $DIR . $value;
    echo $path;
    mkdir($path, 0777, true);
}


