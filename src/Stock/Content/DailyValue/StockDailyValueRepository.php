<?php

namespace App\Stock\Content\DailyValue;

use App\Entity\StockDailyValue;
use App\Entity\StockRecommendation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StockDailyValue>
 *
 * @method StockDailyValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockDailyValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockDailyValue[]    findAll()
 * @method StockDailyValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockDailyValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockDailyValue::class);
    }

    public function save(StockDailyValue $stockDailyValue, bool $flush = true): void
    {
        $this->_em->persist($stockDailyValue);
        if($flush){
            $this->_em->flush();
        }
    }

    /**
     * @return StockDailyValue[] Returns an array of StockDailyValue objects
     */
    public function findByRecommendation(StockRecommendation $recommendation): array
    {
        $qb = $this->createQueryBuilder('s');
        $qb->andWhere('s.recommendation = :recommendation')
            ->setParameter('recommendation', $recommendation->getId());
        $qb->andWhere($qb->expr()->gte('s.date', ':date'))
            ->setParameter('date', $recommendation->getOrderDay());
        $qb->orderBy('s.date', 'ASC');

        return $qb->getQuery()->getResult();
    }

//    public function findOneBySomeField($value): ?StockDailyValue
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
