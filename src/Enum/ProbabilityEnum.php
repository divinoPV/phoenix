<?php

namespace App\Enum;

enum ProbabilityEnum: string
{
    case AboveMid = 'enum.probability.above_mid';
    case Always = 'enum.probability.always';
    case BelowMid = 'enum.probability.below_mid';
    case High = 'enum.probability.high';
    case Low = 'enum.probability.low';
    case Mid = 'enum.probability.mid';
    case Never = 'enum.probability.never';
    case VeryHigh = 'enum.probability.very_high';
    case VeryLow = 'enum.probability.very_low';
}
