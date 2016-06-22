<?php

function arrayToString($array){

	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function simpleXmlSearch($xml){

	foreach ($xml->children() as $child) {

		//echo "<br/>" . $child->getName();
		//echo "<br/>" . $child->attributes;

		foreach($child->attributes() as $attr => $value) {

			if($attr == "class"){

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

	$filter = array("p", "a", "span", "li", "ul", "title", "img", "h1", "h2", "h3", "h4", "h5", "h6", "label", "input");

	foreach ($node->children() as $childNode) {

        foreach($filter as $tag){
            if($tag == $childNode->getName()){
                //echo "<br/>" .$childNode->getName();
                fwrite($file, $childNode->__toString());
            }
        }

		foreach ($childNode->children() as $grandChildNode) {
            foreach($filter as $tag){
                if($tag == $grandChildNode->getName()){
                    fwrite($file, $grandChildNode->__toString());
                    //echo "<br/>" .$grandChildNode->getName();
                }
            }
            nodesToStringRecursiveSearch($grandChildNode, $file);
		}
	}
}

function countWordsInfile($fileName){
	$wordcount =  str_word_count(file_get_contents($fileName));
	return $wordcount;
}


function recursiveIteration($node){

    foreach ($node->children() as $childNode) {
        
        echo "<br/>" .$childNode->getName();

        foreach ($childNode->children() as $grandChildNode) {

            echo "<br/>" .$grandChildNode->getName();
            
            recursiveIteration($grandChildNode);
        }
    }
}


function getNode($node, $nodeName){

    foreach ($node->children() as $childNode) {

        echo "<br/>" .$childNode->getName();

        if($childNode->getName()===$nodeName){

            return $childNode->asXML();
        }

        foreach ($childNode->children() as $grandChildNode) {

            echo "<br/>" .$grandChildNode->getName();

            if($grandChildNode->getName()===$nodeName){

                return $grandChildNode->asXML();
            }

            return getNode($grandChildNode, $nodeName);
        }
    }
}

function getClass($node,$file, $className){

    foreach ($node->children() as $childNode) {

        $attr = $childNode->attributes();

        foreach($attr as $attribute => $value) {

            if($attribute==="class"){

                $classes = explode(" ", $value);

                foreach($classes as $class){

                    if($class === $className){

                        fwrite($file, $childNode->asXML());
                    }
                }
            }
        }

        foreach ($childNode->children() as $grandChildNode) {

            $attr = $grandChildNode->attributes();

            foreach($attr as $attribute => $value) {

                if($attribute==="class"){

                    $classes = explode(" ", $value);

                    foreach($classes as $class){

                        if($class === $className){

                            fwrite($file, $grandChildNode->asXML());
                        }
                    }
                }
            }
            getClass($grandChildNode, $file, $className);
        }
    }
}

function generateCleanHtmlPages($path){

    $MASTER_DIR = "website";

    $xml = loadXMLFile($path);
    $directory = setupDirectory($path);
    $fileName = getFileName($path);

    $newDIR = $MASTER_DIR ."/" . $directory;
    $newFileName = $newDIR. "/". $fileName;

    echo "<br/>" . $newFileName;

    if (!file_exists($newDIR)) {
        mkdir($newDIR, 0777, true);
    }

    $file = fopen($newFileName, "w+");

    //recursiveIteration($xml);
    $title = getNode($xml, "title");

    fwrite($file, "<?php require_once \"../../php/init.php\"; ?><html><head><meta charset=\"utf-8\">");
    fwrite($file,$title );
    fwrite($file, "<script type='text/javascript' src='../../js/main.min.js'></script>");
    fwrite($file, "</head><body>");
    fclose($file);

    $file = fopen($newFileName, "a");
    $mainContent = getClass($xml, $file, "main-content");

    fwrite($file, "</body></html>");
    fclose($file);



}

