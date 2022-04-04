<?php

namespace App\DataFixtures;

use App\Entity\Project;
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
                ->setDescription(\implode(' ', $this->faker->sentences(\rand(15, 45))))
                ->setStatus($this->getReference(StatusFixtures::REFERENCE . \rand(1, StatusFixtures::NUMBER_ELEMENT)))
                ->setStartedAt($startedAt = new \DateTimeImmutable)
                ->setEndedAt((new \DateTimeImmutable)->setTimestamp(\mt_rand($startedAt->getTimestamp(), $startedAt->add(\DateInterval::createFromDateString('7 months'))->getTimestamp())))
                ->setCode($this->faker->currencyCode)
                ->setArchived(\rand(0, 1))
                ->setBudget($this->getReference(BudgetFixtures::REFERENCE . $i))
                ->setPortfolio($this->getReference(PortfolioFixtures::REFERENCE . \rand(1, PortfolioFixtures::NUMBER_ELEMENT)))
                ->setTeamCustomer($this->getReference(TeamFixtures::REFERENCE_CUSTOMER . \rand(1, TeamFixtures::NUMBER_ELEMENT)))
                ->setTeamProject($this->getReference(TeamFixtures::REFERENCE_PROJECT . \rand(1, TeamFixtures::NUMBER_ELEMENT)))
                ->setCreatedBy($this->getReference(\rand(0, 1)
                    ? UserFixtures::REFERENCE['responsible_project'] . \rand(1, UserFixtures::NUMBER_ELEMENT['responsible_project'])
                    : UserFixtures::REFERENCE['responsible_customer'] . \rand(1, UserFixtures::NUMBER_ELEMENT['responsible_customer'])
                ))
            ;
        }, self::REFERENCE);
    }

    public function getDependencies(): array
    {
        return [
            TeamFixtures::class,
            PortfolioFixtures::class,
            BudgetFixtures::class,
            UserFixtures::class,
            StatusFixtures::class
        ];
    }
}
