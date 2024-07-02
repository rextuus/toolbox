<?php

namespace App\User;

use App\Common\Entity\AbstractBaseRepository;
use App\Entity\UserAccessRoles;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractBaseRepository<UserAccessRoles>
 *
 * @method UserAccessRoles|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAccessRoles|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAccessRoles[]    findAll()
 * @method UserAccessRoles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAccessRolesRepository extends AbstractBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAccessRoles::class);
    }

    public function save(UserAccessRoles $userAccessRoles, bool $flush = true): void
    {
        $this->_em->persist($userAccessRoles);
        if($flush){
            $this->_em->flush();
        }
    }
}
