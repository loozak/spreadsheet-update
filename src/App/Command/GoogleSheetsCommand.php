<?php
namespace App\Command;

use App\Classes\JsonHelper;
use App\Classes\SheetGenerator;
use App\Classes\Storage;
use App\Classes\ToolsHelper;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class InSeeCommand
 *
 * @package App\Command
 */
class GoogleSheetsCommand extends Command
{

    private $credentialsDir = __DIR__.'/../../../data/pmweb-5aa3d9098ad8.json';
    private $dataDir = __DIR__.'/../../../data/data.json';
    private $csvDir = __DIR__.'/../../../data/output.csv';

    const STATUS_OK = 'OK';
    const STATUS_ERROR = 'ERROR';
    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('performance:sheet')
            ->setDescription('Insert data to google sheets')
            ->setHelp('Insert data to google sheets')
            ->addArgument(
                'sheetId',
                InputArgument::REQUIRED,
                'Put here sheet id'
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $startDate = microtime(true);
        $io = new SymfonyStyle($input, $output);
        $sheetId = $input->getArgument('sheetId');
        $range = 'Sheet1';

        try {
            $data = JsonHelper::getDataFromJsonFile($this->dataDir);
            $csvFileStorage = Storage::createCsvFileStorage($data, $this->csvDir);

            $sheet = new SheetGenerator($this->credentialsDir);
            $sheet->setClient();
            $sheet->updateSheet($data, $sheetId);

            $status = self::STATUS_OK;
            $rowsProcessed = count($data);
        } catch (Exception $e) {
            $status = self::STATUS_ERROR;
            $rowsProcessed = 0;
            $io->error('Error: '.$e->getMessage());
        }

        $endDate = microtime(true);
        $io->success(
            ToolsHelper::createOutput(
                $sheetId,
                ToolsHelper::getRunTime($startDate, $endDate),
                $status,
                $rowsProcessed,
                ToolsHelper::convertMemorySize(memory_get_usage(true))
            )
        );
    }
}
