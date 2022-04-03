<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Persistence\ObjectManager;

final class StatusFixtures extends BaseFixture
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
            ;
        }, self::REFERENCE);
    }
}
