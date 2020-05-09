<?php


namespace App\Classes;


use DateTime;
use Exception;

class ToolsHelper
{
    /**
     * @param string $sheetId
     * @param int $runtime
     * @param string $status
     * @param int $rowsProcessed
     * @param string $memory
     * @return string
     */
    public static function createOutput(string $sheetId, int $runtime, string $status, int $rowsProcessed, string $memory): string
    {
        try {
            $date = (new DateTime())->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            $date = '';
        }

        return 'SheetId: '.$sheetId.
            ', data operacji: '.$date.
            ', czas trwania: '.$runtime.' ms'.
            ', użyta pamięć: '.$memory.
            ', status operacji: '.$status.
            ', ilość przetworzonych wierszy: '.$rowsProcessed;
    }

    /**
     * @param float $start
     * @param float $end
     * @return int
     */
    public static function getRunTime(float $start, float $end): int
    {
        try{
            $s = sprintf("%06d",($start - floor($start)) * 1000000);
            $sd = new DateTime( date('Y-m-d H:i:s.'.$s, $start));

            $e = sprintf("%06d",($end - floor($end)) * 1000000);
            $ed = new DateTime(date('Y-m-d H:i:s.'.$e, $end));

            return $ed->getTimestamp() - $sd->getTimestamp();
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * @param $size
     * @return string
     */
    public static function convertMemorySize($size): string
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
}
