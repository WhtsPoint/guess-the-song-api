<?php

namespace App\User\Infrastructure\Helper;

use App\User\Domain\Representation\AccessTokenUserData;
use App\User\Domain\Type\Role;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Auth
{
    public function hasRolesOrException(AccessTokenUserData $userData, Role ...$expectedRoles): void
    {
        $roles = $userData->getRoles();
        $expectedRolesNames = array_map(fn (Role $role) => $role->value, $expectedRoles);

        foreach ($roles as $role) if (in_array($role, $expectedRolesNames)) return;

        throw new AccessDeniedHttpException('User has no necessary role');
    }
}