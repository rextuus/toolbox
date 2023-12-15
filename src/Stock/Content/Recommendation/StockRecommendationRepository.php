<?php

namespace App\Stock\Content\Recommendation;

use App\Entity\StockRecommendation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StockRecommendation>
 *
 * @method StockRecommendation|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockRecommendation|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockRecommendation[]    findAll()
 * @method StockRecommendation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockRecommendationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockRecommendation::class);
    }

    public function save(StockRecommendation $stockRecommendation, bool $flush = true): void
    {
        $this->_em->persist($stockRecommendation);
        if($flush){
            $this->_em->flush();
        }
    }
//    /**
//     * @return StockRecommendation[] Returns an array of StockRecommendation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StockRecommendation
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
