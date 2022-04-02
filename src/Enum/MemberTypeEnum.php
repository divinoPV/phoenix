<?php

namespace App\Enum;

use App\Beable\Enum\Trumpable;

enum MemberTypeEnum: string
{
    use Trumpable;

    case ProjectChief = 'member_type.project_chief';
    case Customer = 'member_type.customer';
}
