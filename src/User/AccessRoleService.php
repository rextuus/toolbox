<?php
declare(strict_types=1);

namespace App\User;

use App\Entity\AccessRole;
use Doctrine\ORM\EntityManagerInterface;

class AccessRoleService
{

    public function __construct(
        private readonly AccessRoleRepository   $accessRoleRepository,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function addRoleToEntity(HasAccessRoleInterface $entity, string $roleIdent): void
    {
        $role = $this->accessRoleRepository->findBy(['ident' => $roleIdent]);
        if (count($role) === 1) {
            $accessRole = $role[0];
        } else {
            $accessRole = new AccessRole();
            $accessRole->setIdent($roleIdent);
            $this->accessRoleRepository->save($accessRole);
        }

        $entity->addAccessRole($accessRole);
//        $a = array_map(
//            function ($entity){
//                return $entity->getIdent();
//            },
//            $entity->getAccessRoles()->toArray()
//        );
//        dump($a);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
