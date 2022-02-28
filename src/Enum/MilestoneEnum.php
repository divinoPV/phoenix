<?php

namespace App\Enum;

enum MilestoneEnum: string
{
    case ConceptionStart = 'enum.milestone.conception_start';
    case ConceptionEnd = 'enum.milestone.conception_end';
    case DevelopmentStart = 'enum.milestone.development_start';
    case DevelopmentEnd = 'enum.milestone.development_end';
    case PreproductionDelivery = 'enum.milestone.preproduction_delivery';
    case ProductionDelivery = 'enum.milestone.production_delivery';
    case RecipeStart = 'enum.milestone.recipe_start';
    case RecipeEnd = 'enum.milestone.recipe_end';
}
