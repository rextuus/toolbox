<?php
declare(strict_types=1);

namespace App\Stock\Content\DailyValue;

use App\Entity\StockDailyValue;
use App\Entity\StockRecommendation;
use App\Stock\Content\DailyValue\Data\StockDailyValueData;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class StockDailyValueService
{
    public function __construct(
        private readonly StockDailyValueRepository $repository,
        private readonly StockDailyValueFactory $factory,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function createByData(StockDailyValueData $data, $flush = true): StockDailyValue
    {
        $stockDailyValue = $this->factory->createByData($data);
        $this->repository->save($stockDailyValue, $flush);
        return $stockDailyValue;
    }

    public function update(StockDailyValue $stockDailyValue, StockDailyValueData $data): StockDailyValue
    {
        $stockDailyValue = $this->factory->mapData($data, $stockDailyValue);
        $this->repository->save($stockDailyValue);
        return $stockDailyValue;
    }

    /**
     * @return StockDailyValue[]
     */
    public function findBy(array $conditions): array
    {
        return $this->repository->findBy($conditions);
    }

    /**
     * @return StockDailyValue[]
     */
    public function getOrderedValuesByRecommendation(StockRecommendation $recommendation): array
    {
        return $this->repository->findByRecommendation($recommendation, ['date' => 'ASC']);
    }

    /**
     * @param $stockDailyValues StockDailyValueData[]
     * @return int
     */
    public function createMultipleByData(array $stockDailyValues, StockRecommendation $recommendation): int
    {
        $stored = 0;
        foreach ($stockDailyValues as $stockDailyValue){
            $stockDailyValue->setRecommendation($recommendation);
            if (!$this->repository->findBy(['recommendation' => $recommendation->getId(), 'date' => $stockDailyValue->getDate()])){
                $this->createByData($stockDailyValue, false);
                $stored++;
            }
        }
        $this->entityManager->flush();

        return $stored;
    }
}
