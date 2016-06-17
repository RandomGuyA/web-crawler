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

function arrayToString($array){

	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function loadXML($fileName){
	if (file_exists($fileName)) {
		$xml = simplexml_load_file($fileName);

		return $xml;
	} else {
		exit('Failed to open '. $fileName);
	}
}