<?php

namespace App\Enum;

use App\Beable\Enum\Trumpable;

enum UserRoleEnum: string
{
    use Trumpable;

    case Admin = 'role.admin';
    case User = 'role.user';
}
