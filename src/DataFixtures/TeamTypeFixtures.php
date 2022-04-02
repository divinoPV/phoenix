<?php

namespace App\DataFixtures;

use App\Entity\TeamType;
use App\Enum\TeamTypeEnum;
use Doctrine\Persistence\ObjectManager;

final class TeamTypeFixtures extends BaseFixture
{
    public const REFERENCE = 'team_type_';

    protected function generate(ObjectManager $manager): void
    {
        $this->createFromArray(TeamType::class, TeamTypeEnum::cases(), function (TeamType $teamType, string $value) {
            $teamType->setLabel($value);
        }, self::REFERENCE);
    }
}
