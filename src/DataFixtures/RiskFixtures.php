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

    public const NUMBER_ELEMENT = 367;

    protected function generate(ObjectManager $manager): void
    {
        $this->create(Risk::class, self::NUMBER_ELEMENT, function (Risk $risk) {
            $risk
                ->setName(\implode(' ', $this->faker->words()))
                ->setIdentification($identification = (new \DateTimeImmutable)->setTimestamp(mt_rand((new \DateTimeImmutable)->getTimestamp(), (new \DateTimeImmutable)->add(\DateInterval::createFromDateString('2 weeks'))->getTimestamp())))
                ->setResolution((new \DateTimeImmutable)->setTimestamp(mt_rand($identification->getTimestamp(), $identification->add(\DateInterval::createFromDateString('1 months'))->getTimestamp())))
                ->setProbability(ProbabilityEnum::random())
                ->setSeverity(SeverityEnum::random())
                ->setProject($this->getReference(ProjectFixtures::REFERENCE . rand(1, ProjectFixtures::NUMBER_ELEMENT)))
            ;
        }, self::REFERENCE);
    }

    public function getDependencies(): array
    {
        return [
            ProjectFixtures::class
        ];
    }
}
