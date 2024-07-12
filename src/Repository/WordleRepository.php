<?php

namespace App\Repository;

use App\Entity\Wordle;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wordle>
 */
class WordleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wordle::class);
    }

    public function findNextDateGap(): ?DateTime
    {
        // Fetching only deliveryDates ordered as ascending
        $datesQuery = $this->createQueryBuilder('w')
            ->select('w.deliveryDate')
            ->orderBy('w.deliveryDate', 'ASC')
            ->getQuery();

        $dates = array_map(function($value) {
            return $value['deliveryDate'];
        }, $datesQuery->getArrayResult());

        $dateCount = count($dates);

        // If there are no dates, return today's date
        if ($dateCount == 0) {
            return new DateTime();
        }

        // Iterate over dates and find a gap
        for($dateNr = 0; $dateNr < ($dateCount - 1); $dateNr++) {
            $date1 = $dates[$dateNr];
            $date2 = $dates[$dateNr + 1];

            // Calculate the difference in days
            $difference = $date1->diff($date2)->days;

            // If the difference is more than 1, gap found
            if($difference > 1) {
                return (clone $date1)->modify('+1 day');
            }
        }

        // If no gaps found, return the day after the last date
        return (clone $dates[array_key_last($dates)])->modify('+1 day');
    }

    public function findLastActiveBeforeCurrent(\DateTimeInterface $deliveryDate): ?Wordle
    {
        $qb = $this->createQueryBuilder('w');
        $qb->orderBy('w.deliveryDate', 'DESC')
            ->where($qb->expr()->lt('w.deliveryDate', ':now'))
            ->setParameter('now', ($deliveryDate)->setTime(0, 0))
            ->setMaxResults(1);

        $result = $qb->getQuery()->getResult();

        if (count($result) === 1) {
            return $result[0];
        }

        return null;
    }
}
