<?php

namespace App\Enum;

use App\Beable\Enum\Trumpable;

enum RoleUserEnum: string
{
    use Trumpable;

    case RoleAdmin = 'role.admin';
    case RoleUser = 'role.user';
}
