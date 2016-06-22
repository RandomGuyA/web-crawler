<?php

require_once "php/init.php";

$rootpath = 'structure/';
$pathnames = getListOfPathNamesOfDirectory($rootpath);
//arrayToString($pathnames);
//echo count($pathnames);

$search = "link98754";
$fileName = "list.csv";
$csv = fopen($fileName, "w");


foreach($pathnames as $key=>$path){
    //generatePageInformation($path, $search, $csv);
    generateCleanHtmlPages($path);
}

$pathnames = getListOfPathNamesOfDirectory("website");

foreach($pathnames as $key=>$path){
    generatePageInformation($path, $search, $csv);
}


//arrayToString($pathnames);

$path = $rootpath. "explore\do\cycling-mountain-biking\calorie_counted_routes\http~~~www~breconbeacons~org~explore~things_to_do~cycling_mountain_biking~calorie_counted_routes~around_the_shores_of_llangorse_lake.html";
//generatePageInformation($path, $search, $csv);

fclose($csv);

//generateCleanHtmlPages($path);






