<?php

namespace App\DataFixtures;

use App\Entity\Status;
use App\Enum\ProjectStatus;
use Doctrine\Persistence\ObjectManager;

final class StatusFixtures extends BaseFixture
{
    public const REFERENCE = 'status_';

    public function generate(ObjectManager $manager): void
    {
        $this->createFromArray(Status::class, ProjectStatus::cases(), function (Status $status, string $projectStatus) {
            $status->setLabel($projectStatus);
        }, self::REFERENCE);
    }
}
