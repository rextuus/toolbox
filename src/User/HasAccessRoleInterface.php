<?php
declare(strict_types=1);

namespace App\User;

use App\Entity\AccessRole;

interface HasAccessRoleInterface
{
    public function addAccessRole(AccessRole $accessRole);
}
