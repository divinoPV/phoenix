<?php

namespace App\DataFixtures;

use App\Entity\Fact;
use App\Enum\MilestoneEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class FactFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REFERENCE = 'fact_';

    public const NUMBER_ELEMENT = 145;

    protected function generate(ObjectManager $manager): void
    {
        $this->create(Fact::class, self::NUMBER_ELEMENT, function (Fact $fact) {
            $fact
                ->setName(\implode(' ', $this->faker->words()))
                ->setDescription(\implode(' ', $this->faker->sentences()))
                ->setOccurred(new \DateTimeImmutable())
                ->setMilestone(MilestoneEnum::random())
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
