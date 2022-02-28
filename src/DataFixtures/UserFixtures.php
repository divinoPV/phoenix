<?php

namespace App\DataFixtures;

use App\Enum\MemberTypeEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\{Member, Responsible};
use App\Enum\RoleUserEnum;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REFERENCE_RESPONSIBLE = 'responsible_';

    public const REFERENCE_MEMBER = 'member_';

    public const NUMBER_ELEMENT = 124;

    public const PASSWORD = 'xxx';

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function generate(ObjectManager $manager): void
    {
        $this->create(Responsible::class, self::NUMBER_ELEMENT, function (Responsible $responsible) {
            $responsible
                ->setEmail($this->faker->email())
                ->setName($this->faker->name())
                ->setLastname($this->faker->lastName())
                ->setUsername($this->faker->userName())
                ->setRoles([RoleUserEnum::cases()[rand(0, count(RoleUserEnum::cases()) - 1)]])
                ->setPassword($this->passwordHasher->hashPassword($responsible, self::PASSWORD));
        }, self::REFERENCE_RESPONSIBLE);

        $this->create(Member::class, self::NUMBER_ELEMENT, function (Member $member) {
            $member
                ->setEmail($this->faker->email())
                ->setName($this->faker->name())
                ->setLastname($this->faker->lastName())
                ->setUsername($this->faker->userName())
                ->setRoles([RoleUserEnum::cases()[rand(0, count(RoleUserEnum::cases()) - 1)]])
                ->setPassword($this->passwordHasher->hashPassword($member, self::PASSWORD))
                ->setType($this->getReference(MemberTypeFixtures::REFERENCE . rand(0, count(MemberTypeEnum::cases()) - 1)));
        }, self::REFERENCE_MEMBER);
    }

    public function getDependencies(): array
    {
        return [
            MemberTypeFixtures::class
        ];
    }
}
