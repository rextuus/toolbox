<?php
declare(strict_types=1);

namespace App\User;

use App\Entity\AccessRole;
use App\Entity\User;
use App\User\Data\UserRegistrationData;

class UserService
{
    public function __construct(
        private UserRepository $repository,
        private UserFactory $userFactory,
        private AccessRoleRepository $roleRepository,
    )
    {
    }

    public function initAccessRolesForUser(User $user): void
    {
        $roleIdent = 'USER_'.$user->getId();
        $this->addRole($user, $roleIdent);
    }

    public function addRole(User $user, string $roleIdent){
        $role = $this->roleRepository->findBy(['ident' => $roleIdent]);
        if (count($role) === 1){
            $user->addAccessRole($role[0]);
        }else{
            $accessRole = new AccessRole();
            $accessRole->setIdent($roleIdent);
            $this->roleRepository->save($accessRole);
            $user->addAccessRole($accessRole);
        }

        $this->repository->save($user);
    }

    /**
     * @return User[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function getUser(int $userId): User
    {
        return $this->repository->find($userId);
    }

    public function storeNewUserByData(UserRegistrationData $userRegistrationData)
    {
        $user = $this->userFactory->createByData($userRegistrationData);

        $this->repository->save($user, true);

        return $user;
    }
}
