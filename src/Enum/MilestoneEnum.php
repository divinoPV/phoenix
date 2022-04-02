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

    public function placement(): string
    {
        return match ($this->value) {
            'milestone.conception_start' => 1,
            'milestone.conception_end' => 2,
            'milestone.development_start' => 3,
            'milestone.development_end' => 4,
            'milestone.preproduction_delivery' => 5,
            'milestone.production_delivery' => 6,
            'milestone.recipe_start' => 7,
            'milestone.recipe_end' => 8
        };
    }

    public function mandatory(): bool
    {
        return match ($this->value) {
            'milestone.conception_start',
            'milestone.conception_end',
            'milestone.development_start',
            'milestone.development_end',
            'milestone.production_delivery' => true,
            'milestone.preproduction_delivery',
            'milestone.recipe_start',
            'milestone.recipe_end' => false
        };
    }
}
