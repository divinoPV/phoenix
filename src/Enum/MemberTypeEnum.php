<?php

namespace App\Enum;

use App\Beable\Enum\Trumpable;

enum MemberTypeEnum: string
{
    use Trumpable;

    case Project = 'member_type.project';
    case Customer = 'member_type.customer';
}
