<?php

namespace App\Enum;

use App\Beable\Enum\Trumpable;

enum ProbabilityEnum: string
{
    use Trumpable;

    case AboveMid = 'probability.above_mid';
    case Always = 'probability.always';
    case BelowMid = 'probability.below_mid';
    case High = 'probability.high';
    case Low = 'probability.low';
    case Mid = 'probability.mid';
    case Never = 'probability.never';
    case VeryHigh = 'probability.very_high';
    case VeryLow = 'probability.very_low';
}
