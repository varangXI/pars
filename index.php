<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\XMLWriter;

// изначальный excel файл xlsx
$spreadsheet = IOFactory::load("mysheet.xlsx");

$writer = new XMLWriter();
$writer->openMemory();
$writer->startDocument('1.0', 'UTF-8');
$spreadsheet->getSheet(0)->toArray();
$writer->startElement("nodes");

foreach ($spreadsheet->getActiveSheet()->toArray() as $row) {
    $writer->startElement("dest");
    $writer->writeAttribute("title", $row[0]);

    $writer->startElement("prefix");
    $writer->writeAttribute("values", dd($row[1]));

    $writer->startElement("costout");
    $writer->writeAttribute("cost", $row[2]);

    $writer->endElement();
    $writer->endElement();

    $writer->endElement();
}

function dd($a)
{
    $numbers = explode(':', $a);
    $numbers_array = explode(",", $numbers[1]);
    $new_numbers = [];
    foreach ($numbers_array as $number) {
        $new_numbers[] = trim($numbers[0]) . $number;
    }
    $result = implode(",", $new_numbers);
    return $result;
}

$writer->endElement();
$writer->endDocument();
file_put_contents("file.xml", $writer->outputMemory(true));
