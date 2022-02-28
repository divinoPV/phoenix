<?php

namespace App\DataFixtures;

use App\Entity\Risk;
use App\Enum\ProbabilityEnum;
use App\Enum\SeverityEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class RiskFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REFERENCE = 'risk_';

    public const NUMBER_ELEMENT = 67;

    protected function generate(ObjectManager $manager): void
    {
        $this->create(Risk::class, self::NUMBER_ELEMENT, function (Risk $risk) {
            $risk
                ->setName(\implode(' ', $this->faker->words()))
                ->setIdentification($identification = new \DateTimeImmutable())
                ->setProbability($this->getReference(ProbabilityFixtures::REFERENCE . rand(0, count(ProbabilityEnum::cases()) - 1)))
                ->setResolution((new \DateTimeImmutable())->setTimestamp(mt_rand($identification->getTimestamp(), $identification->add(\DateInterval::createFromDateString('5 months'))->getTimestamp())))
                ->setSeverity($this->getReference(SeverityFixtures::REFERENCE . rand(0, count(SeverityEnum::cases()) - 1)));
        }, self::REFERENCE);
    }

    public function getDependencies(): array
    {
        return [
            ProbabilityFixtures::class,
            SeverityFixtures::class
        ];
    }
}
