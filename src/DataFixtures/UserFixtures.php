<?php

namespace App\DataFixtures;

use App\Enum\MemberTypeEnum;
use App\Entity\{Admin, Member, Responsible};
use App\Enum\UserRoleEnum;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends BaseFixture
{
    public const REFERENCE_RESPONSIBLE = 'responsible_';

    public const REFERENCE_MEMBER = 'member_';

    public const REFERENCE_ADMIN = 'admin_';

    public const NUMBER_ELEMENT = 30;

    public const PASSWORD = 'xxx';

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function generate(ObjectManager $manager): void
    {
        $this->create(Responsible::class, self::NUMBER_ELEMENT, function (Responsible $responsible) {
            $responsible
                ->setEmail($this->faker->email())
                ->setFirstName($this->faker->name())
                ->setLastName($this->faker->lastName())
                ->setUserName($this->faker->userName())
                ->setPassword($this->passwordHasher->hashPassword($responsible, self::PASSWORD))
                ->setRoles([UserRoleEnum::User])
            ;
        }, self::REFERENCE_RESPONSIBLE);

        $this->create(Member::class, self::NUMBER_ELEMENT, function (Member $member) {
            $member
                ->setEmail($this->faker->email())
                ->setFirstName($this->faker->name())
                ->setLastName($this->faker->lastName())
                ->setUserName($this->faker->userName())
                ->setPassword($this->passwordHasher->hashPassword($member, self::PASSWORD))
                ->setRoles([UserRoleEnum::User])
                ->setType(MemberTypeEnum::random())
            ;
        }, self::REFERENCE_MEMBER);

        $this->create(Admin::class, self::NUMBER_ELEMENT, function (Admin $admin) {
            $admin
                ->setEmail($this->faker->email())
                ->setFirstName($this->faker->name())
                ->setLastName($this->faker->lastName())
                ->setUserName($this->faker->userName())
                ->setPassword($this->passwordHasher->hashPassword($admin, self::PASSWORD))
                ->setRoles([UserRoleEnum::Admin])
            ;
        }, self::REFERENCE_ADMIN);
    }
}
