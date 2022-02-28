<?php

namespace App\DataFixtures;

use App\Entity\ProjectRisk;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ProjectRiskFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const NUMBER_ELEMENT = RiskFixtures::NUMBER_ELEMENT;

    protected function generate(ObjectManager $manager): void
    {
        $this->create(ProjectRisk::class, self::NUMBER_ELEMENT, function (ProjectRisk $risk, int $i) {
            $risk
                ->setProject($this->getReference(ProjectFixtures::REFERENCE . $i))
                ->setRisk($this->getReference(RiskFixtures::REFERENCE . $i));

        });
    }

    public function getDependencies(): array
    {
        return [
            ProjectFixtures::class,
            RiskFixtures::class
        ];
    }
}
