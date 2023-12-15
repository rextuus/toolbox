<?php
declare(strict_types=1);

namespace App\Stock\Content\Recommendation;

use App\Entity\StockRecommendation;
use App\Stock\Content\Recommendation\Data\StockRecommendationData;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class StockRecommendationFactory
{
    public function createByData(StockRecommendationData $data): StockRecommendation
    {
        $stockRecommendation = $this->createNewInstance();
        $this->mapData($data, $stockRecommendation);
        return $stockRecommendation;
    }

    public function mapData(StockRecommendationData $data, StockRecommendation $stockRecommendation): StockRecommendation
    {
        $stockRecommendation->setCompanyName($data->getCompanyName());
        $stockRecommendation->setOrderDay($data->getRecommendationDay());
        $stockRecommendation->setValueCurrent(0.0);
        $stockRecommendation->setValueByOrder(0.0);

        return $stockRecommendation;
    }

    private function createNewInstance(): StockRecommendation
    {
        return new StockRecommendation();
    }
}
