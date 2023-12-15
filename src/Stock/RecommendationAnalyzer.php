<?php
declare(strict_types=1);

namespace App\Stock;

use App\Entity\StockDailyValue;
use App\Stock\Content\DailyValue\StockDailyValueService;
use App\Stock\Content\Recommendation\StockRecommendationService;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class RecommendationAnalyzer
{
    public function __construct(private StockDailyValueService $stockDailyValueService, private StockRecommendationService $recommendationService)
    {
    }

    public function analyzeRecommendation(string $name)
    {
        $recommendation = $this->recommendationService->findByName($name);
        $values = $this->stockDailyValueService->getOrderedValuesByRecommendation($recommendation);

        $startValue = $values[0]->getLow();
        dump($values[0]->getDate());
        dump($startValue);


        $maxDate = $values[0]->getDate();
        $maxValue = $values[0]->getLow();
        foreach ($values as $value){
            if ($value->getLow() > $maxValue){
                $maxDate = $value->getDate();
                $maxValue = $value->getLow();
            }
        }

        dump($maxDate);
        dump($maxValue);
    }
}
