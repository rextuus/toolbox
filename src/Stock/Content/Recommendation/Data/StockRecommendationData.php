<?php
declare(strict_types=1);

namespace App\Stock\Content\Recommendation\Data;

use DateTime;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class StockRecommendationData
{
    private ?string $companyName;
    private ?DateTime $recommendationDay;

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): StockRecommendationData
    {
        $this->companyName = $companyName;
        return $this;
    }

    public function getRecommendationDay(): ?DateTime
    {
        return $this->recommendationDay;
    }

    public function setRecommendationDay(?DateTime $recommendationDay): StockRecommendationData
    {
        $this->recommendationDay = $recommendationDay;
        return $this;
    }
}
