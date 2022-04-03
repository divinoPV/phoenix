<?php

namespace App\Enum;

use App\Beable\Enum\Trumpable;

enum UserRoleEnum: string
{
    use Trumpable;

    case Admin = 'ROLE_ADMIN';
    case User = 'ROLE_USER';
    case Member = 'ROLE_MEMBER';
    case Responsible = 'ROLE_RESPONSIBLE';
}
