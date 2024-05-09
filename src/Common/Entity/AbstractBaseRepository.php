<?php

declare(strict_types=1);

namespace App\Common\Entity;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;

/**
 * @template T of object
 * @template-extends ServiceEntityRepository<T>
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
abstract class AbstractBaseRepository extends ServiceEntityRepository
{
    /**
     * @throws ORMException
     */
    public function persist(mixed $entity): void
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();
        $em->persist($entity);
        $em->flush($entity);
    }

    /**
     * @throws ORMException
     */
    public function remove(mixed $entity): void
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();
        $em->remove($entity);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function flush(): void
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();
        $em->flush();
    }

    /**
     * @throws TransactionRequiredException
     * @throws ORMException
     */
    public function refresh(mixed $entity): void
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();
        $em->refresh($entity);
    }
}
