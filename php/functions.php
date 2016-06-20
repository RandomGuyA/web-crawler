<?php

function arrayToString($array){

	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function simpleXmlSearch($xml){

	foreach ($xml->children() as $child) {
		// echo "<br/>" . $child->getName();
		//echo "<br/>" . $child->attributes;

		foreach($child->attributes() as $attr => $value) {

			if($attr == "class"){

				/*
				echo "<br/>" . $child->getName();
				echo "<br/>" . $child->attributes;
				echo $attr,'="',$value,"\"\n";
                */

				$classes = explode(" ", $value);

				foreach($classes as $class){
					if($class=="main-content"){
						//echo "<br/>" . $class;
						//arrayToString($child);

						$fileName = "data.txt";
						$file = fopen($fileName, "w");

						nodesToStringRecursiveSearch($child, $file);
						fclose($file);
						countWordsInfile($fileName);
					}
				}
			}
		}
		simpleXmlSearch($child);
	}
}

function nodesToStringRecursiveSearch($node, $file){

	foreach ($node->children() as $childNode) {

		//echo "<br/>" .$childNode->__toString();
		fwrite($file, $childNode->__toString());

		foreach ($childNode->children() as $grandChildNode) {

			//echo "<br/>" .$grandChildNode->__toString();
			fwrite($file, $grandChildNode->__toString());

			nodesToStringRecursiveSearch($grandChildNode, $file);
		}
	}

}

function countWordsInfile($fileName){
	$wordcount =  str_word_count(file_get_contents($fileName));
	return $wordcount;
}