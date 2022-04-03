<?php

namespace App\DataFixtures;

use App\Enum\MemberTypeEnum;
use App\Entity\User;
use App\Enum\UserRoleEnum;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends BaseFixture
{
    public const REFERENCE = [
        'responsible_project' => 'responsible_project_',
        'responsible_customer' => 'responsible_customer_',
        'member_project' => 'member_project_',
        'member_customer' => 'member_customer_',
        'admin' => 'admin_'
    ];

    public const NUMBER_ELEMENT = [
        'responsible_project' => 7,
        'responsible_customer' => 15,
        'member_project' => 24,
        'member_customer' => 35,
        'admin' => 4
    ];

    public const PASSWORD = 'xxx';

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function generate(ObjectManager $manager): void
    {
        $this->generateUser(
            self::NUMBER_ELEMENT['responsible_project'],
            [UserRoleEnum::User, UserRoleEnum::Responsible],
            MemberTypeEnum::Project,
            self::REFERENCE['responsible_project'],
            'responsible_project'
        );

        $this->generateUser(
            self::NUMBER_ELEMENT['responsible_customer'],
            [UserRoleEnum::User, UserRoleEnum::Responsible],
            MemberTypeEnum::Customer,
            self::REFERENCE['responsible_customer'],
            'responsible_customer'
        );

        $this->generateUser(
            self::NUMBER_ELEMENT['member_project'],
            [UserRoleEnum::User, UserRoleEnum::Member],
            MemberTypeEnum::Project,
            self::REFERENCE['member_project'],
            'member_project'
        );

        $this->generateUser(
            self::NUMBER_ELEMENT['member_customer'],
            [UserRoleEnum::User, UserRoleEnum::Member],
            MemberTypeEnum::Customer,
            self::REFERENCE['member_customer'],
            'member_customer'
        );

        $this->generateUser(
            self::NUMBER_ELEMENT['admin'],
            [UserRoleEnum::Admin],
            null,
            self::REFERENCE['admin'],
            'admin'
        );
    }

    public function generateUser(int $count, array $roles, ?MemberTypeEnum $type, string $reference, string $email): void
    {
        $this->create(User::class, $count, function (User $user, int $i) use ($roles, $type, $email) {
            $user
                ->setEmail($email.$i.'@phoenix.co')
                ->setFirstName($this->faker->name())
                ->setLastName($this->faker->lastName())
                ->setUserName($this->faker->userName())
                ->setPassword($this->passwordHasher->hashPassword($user, self::PASSWORD))
                ->setRoles($roles)
                ->setType($type)
            ;
        }, $reference);
    }
}
