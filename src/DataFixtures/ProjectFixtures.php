<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Enum\ProjectStatus;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ProjectFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function generate(ObjectManager $manager): void
    {
        $this->create(Project::class, 24, function (Project $project) {
            $project
                ->setName(implode(' ', $this->faker->words()))
                ->setDescription(implode(' ', $this->faker->sentences()))
                ->setStatus($this->getReference(StatusFixtures::REFERENCE . rand(0, count(ProjectStatus::cases()) - 1)))
                ->setStartedAt(new \DateTimeImmutable());
        });
    }

    public function getDependencies(): array
    {
        return [
            StatusFixtures::class
        ];
    }
}
