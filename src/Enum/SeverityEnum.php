<?php

namespace App\Enum;

use App\Beable\Enum\Trumpable;

enum SeverityEnum: string
{
    use Trumpable;

    case Blocker = 'severity.blocker';
    case Critical = 'severity.critical';
    case High = 'severity.high';
    case Info = 'severity.info';
    case Low = 'severity.low';
    case Major = 'severity.major';
    case Medium = 'severity.medium';
    case Minor = 'severity.minor';
}
