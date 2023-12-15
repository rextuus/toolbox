<?php
declare(strict_types=1);

namespace App\Stock\Content\DailyValue\Data;

use App\Entity\StockRecommendation;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class StockDailyValueData
{
    private \DateTime $date;
    private float $start;
    private float $final;
    private float $high;
    private float $low;
    private StockRecommendation $recommendation;

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): StockDailyValueData
    {
        $this->date = $date;
        return $this;
    }

    public function getStart(): float
    {
        return $this->start;
    }

    public function setStart(float $start): StockDailyValueData
    {
        $this->start = $start;
        return $this;
    }

    public function getFinal(): float
    {
        return $this->final;
    }

    public function setFinal(float $final): StockDailyValueData
    {
        $this->final = $final;
        return $this;
    }

    public function getHigh(): float
    {
        return $this->high;
    }

    public function setHigh(float $high): StockDailyValueData
    {
        $this->high = $high;
        return $this;
    }

    public function getLow(): float
    {
        return $this->low;
    }

    public function setLow(float $low): StockDailyValueData
    {
        $this->low = $low;
        return $this;
    }

    public function getRecommendation(): StockRecommendation
    {
        return $this->recommendation;
    }

    public function setRecommendation(StockRecommendation $recommendation): StockDailyValueData
    {
        $this->recommendation = $recommendation;
        return $this;
    }
}
