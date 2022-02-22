<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\RoleUser;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends BaseFixture
{
    public const PASSWORD = 'xxx';

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function generate(ObjectManager $manager): void
    {
        $this->create(User::class, 39, function (User $user) {
            $user
                ->setEmail($this->faker->email)
                ->setName($this->faker->name)
                ->setLastname($this->faker->lastName)
                ->setUsername($this->faker->userName)
                ->setRoles([RoleUser::cases()[rand(0, count(RoleUser::cases()) - 1)]])
                ->setPassword($this->passwordHasher->hashPassword($user, self::PASSWORD));
        });
    }
}
