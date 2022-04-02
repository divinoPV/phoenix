<?php

namespace App\Enum;

use App\Beable\Enum\Trumpable;

enum MilestoneEnum: string
{
    use Trumpable;

    case ConceptionStart = 'milestone.conception_start';
    case ConceptionEnd = 'milestone.conception_end';
    case DevelopmentStart = 'milestone.development_start';
    case DevelopmentEnd = 'milestone.development_end';
    case PreproductionDelivery = 'milestone.preproduction_delivery';
    case ProductionDelivery = 'milestone.production_delivery';
    case RecipeStart = 'milestone.recipe_start';
    case RecipeEnd = 'milestone.recipe_end';
}
