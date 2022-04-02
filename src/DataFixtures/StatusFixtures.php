<?php

namespace App\DataFixtures;

use App\Entity\Status;
use App\Enum\StatusEnum;
use Doctrine\Persistence\ObjectManager;

final class StatusFixtures extends BaseFixture
{
    public const REFERENCE = 'status_';

    public function generate(ObjectManager $manager): void
    {
        $this->createFromArray(Status::class, StatusEnum::cases(), function (Status $status, string $projectStatus, int $key) {
            $status
                ->setLabel($projectStatus)
                ->setColor($this->faker->hexColor())
                ->setPlacement($key + 1)
            ;
        }, self::REFERENCE);
    }
}
