<?php
namespace App\Classes;

use Google_Client;
use Google_Service_Sheets;

class SheetGenerator {

    private $credentialsDir;
    private $client;
    private $service;

    public function __construct(string $credentialsDir)
    {
        $this->credentialsDir = $credentialsDir;
    }

    public function setClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('PerformanceMedia Test');
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig($this->credentialsDir);

        $this->client = $client;
        $this->service = new Google_Service_Sheets($this->client);
    }

    public function updateSheet(array $data, string $sheetId)
    {
        $result = $this->service->spreadsheets_values->get($sheetId, 'Sheet1');
        /**
         * TODO: problem z dostaniem się do arkusza, możliwe, że arkusz nie jest stworzony, ale w przypadku tworzenia arkusza
         * TODO: dostaję nowy id arkusza co jest sprzeczne z założeniami zadania.
         */
    }
}
