<?php

namespace App\Enum;

enum SeverityEnum: string
{
    case Blocker = 'enum.severity.blocker';
    case Critical = 'enum.severity.critical';
    case High = 'enum.severity.high';
    case Info = 'enum.severity.info';
    case Low = 'enum.severity.low';
    case Major = 'enum.severity.major';
    case Medium = 'enum.severity.medium';
    case Minor = 'enum.severity.minor';
}
