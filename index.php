<?php

	include "php/init.php";

	$urls = readTxtFile("data/urllist/updated-list.txt");
	$outputFile = fopen("data/output.txt", "w");

	fwrite($outputFile, '<?xml version="1.0" encoding="UTF-8"?><config>');

	foreach($urls as $key=>$value) {

		$spaces = array("\n", "\r", "\t");
        $value = str_replace($spaces, "",  $value);

		if ((strpos($value, 'filter') !== false)||(strpos($value, 'query') !== false)) {
			echo "<h1>".$value . "</h1>";
		}else {
			$filter = array("/", "\\", ":", ".", "?", "&");
			$fileName = str_replace($filter, "~", $value);
            $fileName = str_replace("http---www-", "",  $fileName);
            $fileName = str_replace(" ", "",  $fileName);
			$fileName = str_replace($spaces, "",  $fileName);

            echo "<h2>" . $fileName . "</h2>";

			fwrite($outputFile, '<var-def name="page'.$key.'"><html-to-xml><http url="'.$value.'"/></html-to-xml></var-def>');
			fwrite($outputFile, '<file action="write" type="text" path="'.$fileName.'.html"><template>${page'.$key.'} ${"link98754-'.$value.'"} ${sys.cr}${sys.lf}</template></file>');

		}
	}
	fwrite($outputFile, '</config>');
	fclose($outputFile);