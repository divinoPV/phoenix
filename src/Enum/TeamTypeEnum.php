<?php

namespace App\Enum;

use App\Beable\Enum\Trumpable;

enum TeamTypeEnum: string
{
    use Trumpable;

    case Project = 'team_type.project';
    case Customer = 'team_type.customer';
}
