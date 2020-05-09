<?php

use App\Command\GoogleSheetsCommand;
use Zend\ServiceManager\ServiceManager;

return [
    'factories' => [
        GoogleSheetsCommand::class => function (ServiceManager $serviceManager) {
            return new GoogleSheetsCommand();
        },
    ],
];
