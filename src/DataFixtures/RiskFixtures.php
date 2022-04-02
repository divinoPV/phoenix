<?php

namespace App\DataFixtures;

use App\Entity\Risk;
use App\Enum\ProbabilityEnum;
use App\Enum\SeverityEnum;
use Doctrine\Persistence\ObjectManager;

final class RiskFixtures extends BaseFixture
{
    public const REFERENCE = 'risk_';

    public const NUMBER_ELEMENT = 67;

    protected function generate(ObjectManager $manager): void
    {
        $this->create(Risk::class, self::NUMBER_ELEMENT, function (Risk $risk) {
            $risk
                ->setName(\implode(' ', $this->faker->words()))
                ->setIdentification($identification = new \DateTimeImmutable())
                ->setResolution((new \DateTimeImmutable())->setTimestamp(mt_rand($identification->getTimestamp(), $identification->add(\DateInterval::createFromDateString('5 months'))->getTimestamp())))
                ->setProbability(ProbabilityEnum::random())
                ->setSeverity(SeverityEnum::random())
            ;
        }, self::REFERENCE);
    }
}
