<?php


namespace App\Classes;


class JsonHelper
{
    /**
     * @param string $inputDir
     * @return mixed
     */
    public static function getDataFromJsonFile(string $inputDir) {
        return json_decode(file_get_contents($inputDir), true);
    }
}
