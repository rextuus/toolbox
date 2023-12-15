<?php
declare(strict_types=1);

namespace App\Stock\Content\Recommendation;

use App\Entity\StockRecommendation;
use App\Stock\Content\Recommendation\Data\StockRecommendationData;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class StockRecommendationService
{
    public function __construct(private readonly StockRecommendationRepository $repository, private readonly StockRecommendationFactory $factory)
    {
    }

    public function createByData(StockRecommendationData $data): StockRecommendation
    {
        $stockRecommendation = $this->factory->createByData($data);
        $this->repository->save($stockRecommendation);
        return $stockRecommendation;
    }

    public function update(StockRecommendation $stockRecommendation, StockRecommendationData $data): StockRecommendation
    {
        $stockRecommendation = $this->factory->mapData($data, $stockRecommendation);
        $this->repository->save($stockRecommendation);
        return $stockRecommendation;
    }

    /**
     * @return StockRecommendation[]
     */
    public function findBy(array $conditions): array
    {
        return $this->repository->findBy($conditions);
    }

    public function findByName(string $name): StockRecommendation
    {
        return $this->repository->findOneBy(['companyName' => $name]);
    }
}
