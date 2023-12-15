<?php
declare(strict_types=1);

namespace App\Stock\Content;

use App\Stock\Content\DailyValue\Data\StockDailyValueData;
use DateTime;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class CsvReader
{
    public function __construct(private KernelInterface $kernel)
    {
    }

    /**
     * @return StockDailyValueData[]
     */
    public function readFinancialDataFromCsv(string $fileName): array
    {
        $filePath = $this->kernel->getProjectDir() . '/public/reports/' . $fileName;

        if (!file_exists($filePath)) {
            throw new FileNotFoundException('File not found: ' . $fileName);
        }

        $financialData = [];
        $file = fopen($filePath, 'r');
        if ($file) {
            $rowNr = 0;
            while (($row = fgetcsv($file, 1000, ';')) !== false) {
                $rowNr = $rowNr + 1;
                if ($rowNr === 1){
                    continue;
                }

                $data = new StockDailyValueData();

                $data->setDate(new DateTime($row[0]));
                $data->setStart((float) str_replace(',', '.', $row[1]));
                $data->setHigh((float) str_replace(',', '.', $row[2]));
                $data->setLow((float) str_replace(',', '.', $row[3]));
                $data->setFinal((float) str_replace(',', '.', $row[4]));

                $financialData[] = $data;
            }
            fclose($file);
        }

        return $financialData;
    }
}
