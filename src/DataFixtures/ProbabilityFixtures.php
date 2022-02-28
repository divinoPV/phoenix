<?php

namespace App\DataFixtures;

use App\Entity\Probability;
use App\Enum\ProbabilityEnum;
use Doctrine\Persistence\ObjectManager;

final class ProbabilityFixtures extends BaseFixture
{
    public const REFERENCE = 'probability_';

    protected function generate(ObjectManager $manager): void
    {
        $this->createFromArray(Probability::class, ProbabilityEnum::cases(), function (Probability $probability, string $value) {
            $probability
                ->setLabel($value)
                ->setColor($this->faker->hexColor());
        }, self::REFERENCE);
    }
}
