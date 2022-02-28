<?php

namespace App\DataFixtures;

use App\Entity\TeamCustomer;
use App\Entity\TeamProject;
use App\Enum\MemberTypeEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class TeamFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REFERENCE_CUSTOMER = 'team_customer_';

    public const REFERENCE_PROJECT = 'team-project_';

    public const NUMBER_ELEMENT = 24;

    protected function generate(ObjectManager $manager): void
    {
        $this->create(TeamCustomer::class, self::NUMBER_ELEMENT, function (TeamCustomer $team) {
            $team->setName(\implode(' ', $this->faker->words()))
                ->setResponsible($this->getReference(UserFixtures::REFERENCE_RESPONSIBLE . rand(1, UserFixtures::NUMBER_ELEMENT)));
        }, self::REFERENCE_CUSTOMER);

        $this->create(TeamProject::class, self::NUMBER_ELEMENT, function (TeamProject $team) {
            $team->setName(\implode(' ', $this->faker->words()))
                ->setResponsible($this->getReference(UserFixtures::REFERENCE_RESPONSIBLE . rand(1, UserFixtures::NUMBER_ELEMENT)));
        }, self::REFERENCE_PROJECT);


        foreach (range(1, UserFixtures::NUMBER_ELEMENT) as $i) {
            $member = $this->getReference(UserFixtures::REFERENCE_MEMBER . $i);
            $manager->persist($member->setTeam($this->getReference((
                $member->getType() === MemberTypeEnum::Customer
                    ? self::REFERENCE_CUSTOMER
                    : self::REFERENCE_PROJECT
            ) . rand(1, self::NUMBER_ELEMENT))));
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }
}
