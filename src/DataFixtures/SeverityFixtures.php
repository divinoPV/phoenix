<?php

namespace App\DataFixtures;

use App\Entity\Severity;
use App\Enum\SeverityEnum;
use Doctrine\Persistence\ObjectManager;

final class SeverityFixtures extends BaseFixture
{
    public const REFERENCE = 'severity_';

    protected function generate(ObjectManager $manager): void
    {
        $this->createFromArray(Severity::class, SeverityEnum::cases(), function (Severity $severity, string $value) {
            $severity
                ->setLabel($value)
                ->setColor($this->faker->hexColor());
        }, self::REFERENCE);
    }
}
