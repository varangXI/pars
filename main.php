<?php
require_once 'index.php';

//xlsx файл преобразованный в xml 
$filename = 'file.xml';

if (file_exists($filename)) {
    echo "Файл $filename существует";
    $xml1 = simplexml_load_file($filename);
} else {
    echo "Файл $filename не существует";
}

$xml2 = simplexml_load_file("in.xml");

foreach ($xml2 as $node) {
    $nodeExists = false;
    foreach ($xml1 as $existingNode) {
        if ($existingNode->getName() == $node->getName()) {
            $nodeExists = true;
            break;
        }
    }
    if (!$nodeExists) {
        $xml1->addChild($node->getName(), $node);
    }
}

$xml1->asXML("merged_file.xml");
