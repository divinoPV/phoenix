<?php

namespace App\DataFixtures;

use App\Entity\Budget;
use Doctrine\Persistence\ObjectManager;

final class BudgetFixtures extends BaseFixture
{
    public const REFERENCE = 'budget_';

    public const NUMBER_ELEMENT = ProjectFixtures::NUMBER_ELEMENT;

    protected function generate(ObjectManager $manager): void
    {
        $this->create(Budget::class, self::NUMBER_ELEMENT, function (Budget $budget) {
            $budget
                ->setOriginal($original = \random_int(2_000, 80_000))
                ->setConsumed($consumed = \random_int(400, $original))
                ->setRemaining($remaining = \random_int(400, $original))
                ->setLanding($consumed + $remaining)
            ;
        }, self::REFERENCE);
    }
}
