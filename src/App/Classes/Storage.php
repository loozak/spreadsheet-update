<?php


namespace App\Classes;


use App\Model\Row;
use PhpObjectHistory\Comparer\ObjectComparer;
use PhpObjectHistory\ObjectHistory;
use PhpObjectHistory\Storage\CsvFileStorage;

class Storage
{
    public static function createCsvFileStorage(array $input, string $outputDir): CsvFileStorage
    {
        $storage = new CsvFileStorage();
        $storage->setCsvFilePath($outputDir);
        $objectComparer = new ObjectComparer();
        $objectHistory = new ObjectHistory(
            $storage,
            $objectComparer
        );

        foreach ($input as $r) {
            $row = new Row();
            $row->setId($r['ID']);
            $row->setTitle($r['title']);
            $row->setDescription($r['description']);
            $row->setSummary($r['summary']);
            $row->setGtin($r['gtin']);
            $row->setMpn($r['mpn']);
            $row->setPrice($r['price']);
            $row->setShortcode($r['shortcode']);
            $row->setCategory($r['category']);
            $row->setSub($r['sub']);
            $row->setDate($r['date']);

            $objectHistory->addObject($row);
        }
        return $storage;
    }
}
