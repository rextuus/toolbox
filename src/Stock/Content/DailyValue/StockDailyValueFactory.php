<?php
declare(strict_types=1);

namespace App\Stock\Content\DailyValue;

use App\Entity\StockDailyValue;
use App\Stock\Content\DailyValue\Data\StockDailyValueData;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class StockDailyValueFactory
{
    public function createByData(StockDailyValueData $data): StockDailyValue
    {
        $stockDailyValue = $this->createNewInstance();
        $this->mapData($data, $stockDailyValue);
        return $stockDailyValue;
    }

    public function mapData(StockDailyValueData $data, StockDailyValue $stockDailyValue): StockDailyValue
    {
        $stockDailyValue->setStart($data->getStart());
        $stockDailyValue->setFinal($data->getFinal());
        $stockDailyValue->setLow($data->getLow());
        $stockDailyValue->setHigh($data->getHigh());
        $stockDailyValue->setDate($data->getDate());
        $stockDailyValue->setRecommendation($data->getRecommendation());

        return $stockDailyValue;
    }

    private function createNewInstance(): StockDailyValue
    {
        return new StockDailyValue();
    }
}
