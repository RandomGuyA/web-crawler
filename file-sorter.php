<?php

include "php/init.php";

$STRUCTURE = "data/folder-structure.txt";
$FOLDER = "data/";
$DIR = $FOLDER . "raw-xml";

$files= getFileNamesFromDirectory($DIR);
sortFilesIntoFolders($files, $STRUCTURE);




