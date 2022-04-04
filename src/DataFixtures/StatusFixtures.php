<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class StatusFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REFERENCE = 'status';

    public const NUMBER_ELEMENT = 5;

    public function generate(ObjectManager $manager): void
    {
        $this->create(Status::class, self::NUMBER_ELEMENT, function (Status $status, int $i) {
            $status
                ->setName($this->faker->word)
                ->setColor($this->faker->hexColor)
                ->setPlacement($i)
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
            UserFixtures::class
        ];
    }
}
