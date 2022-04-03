<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Enum\StatusEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ProjectFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REFERENCE = 'project_';

    public const NUMBER_ELEMENT = 89;

    protected function generate(ObjectManager $manager): void
    {
        $this->create(Project::class, self::NUMBER_ELEMENT, function (Project $project, int $i) {
            $project
                ->setName(\implode(' ', $this->faker->words()))
                ->setDescription(\implode(' ', $this->faker->sentences(rand(15, 45))))
                ->setStatus(StatusEnum::random())
                ->setStartedAt($startedAt = new \DateTimeImmutable)
                ->setEndedAt((new \DateTimeImmutable)->setTimestamp(mt_rand($startedAt->getTimestamp(), $startedAt->add(\DateInterval::createFromDateString('9 months'))->getTimestamp())))
                ->setCode($this->faker->word())
                ->setPortfolio($this->getReference(PortfolioFixtures::REFERENCE . $i))
                ->setBudget($this->getReference(BudgetFixtures::REFERENCE . $i))
                ->setTeamCustomer($this->getReference(TeamFixtures::REFERENCE_CUSTOMER . rand(1, TeamFixtures::NUMBER_ELEMENT)))
                ->setTeamProject($this->getReference(TeamFixtures::REFERENCE_PROJECT . rand(1, TeamFixtures::NUMBER_ELEMENT)))
                ->setCreatedBy($this->getReference(UserFixtures::REFERENCE_RESPONSIBLE . rand(1, UserFixtures::NUMBER_ELEMENT)))
            ;
        }, self::REFERENCE);
    }

    public function getDependencies(): array
    {
        return [
            TeamFixtures::class,
            PortfolioFixtures::class,
            BudgetFixtures::class,
            UserFixtures::class
        ];
    }
}
