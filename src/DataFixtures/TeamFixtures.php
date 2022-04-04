<?php

namespace App\DataFixtures;

use App\Entity\Team;
use App\Enum\MemberTypeEnum;
use App\Enum\TeamTypeEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class TeamFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REFERENCE_CUSTOMER = 'team_customer_';

    public const REFERENCE_PROJECT = 'team-project_';

    public const NUMBER_ELEMENT = 24;

    protected function generate(ObjectManager $manager): void
    {
        $this->create(Team::class, self::NUMBER_ELEMENT, function (Team $team) {
            $team
                ->setName(\implode(' ', $this->faker->words()))
                ->setType(TeamTypeEnum::Project)
                ->setResponsible($respnsible = $this->getReference(UserFixtures::REFERENCE['responsible_project'] . \rand(1, UserFixtures::NUMBER_ELEMENT['responsible_project'])))
                ->setCreatedBy($respnsible)
            ;
        }, self::REFERENCE_PROJECT);

        $this->create(Team::class, self::NUMBER_ELEMENT, function (Team $team) {
            $team
                ->setName(\implode(' ', $this->faker->words()))
                ->setType(TeamTypeEnum::Customer)
                ->setResponsible($respnsible = $this->getReference(UserFixtures::REFERENCE['responsible_customer'] . \rand(1, UserFixtures::NUMBER_ELEMENT['responsible_customer'])))
                ->setCreatedBy($respnsible)
            ;
        }, self::REFERENCE_CUSTOMER);

        $this->assignTeamToMembers($manager, UserFixtures::NUMBER_ELEMENT['responsible_project'], UserFixtures::REFERENCE['responsible_project']);
        $this->assignTeamToMembers($manager, UserFixtures::NUMBER_ELEMENT['responsible_customer'], UserFixtures::REFERENCE['responsible_customer']);
        $this->assignTeamToMembers($manager, UserFixtures::NUMBER_ELEMENT['member_project'], UserFixtures::REFERENCE['member_project']);
        $this->assignTeamToMembers($manager, UserFixtures::NUMBER_ELEMENT['member_customer'], UserFixtures::REFERENCE['member_customer']);
    }

    public function assignTeamToMembers(ObjectManager $manager, int $count, string $reference): void
    {
        foreach (range(1, $count) as $i) {
            $member = $this->getReference($reference . $i);
            $manager->persist($member->setTeam($this->getReference((
                $member->getType() === MemberTypeEnum::Customer
                    ? self::REFERENCE_CUSTOMER
                    : self::REFERENCE_PROJECT
            ) . \rand(1, self::NUMBER_ELEMENT))));
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
