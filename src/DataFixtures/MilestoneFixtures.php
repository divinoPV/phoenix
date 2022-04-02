<?php

namespace App\DataFixtures;

use App\Entity\Milestone;
use App\Enum\MilestoneEnum;
use Doctrine\Persistence\ObjectManager;

final class MilestoneFixtures extends BaseFixture
{
    public const REFERENCE = 'milestone_';

    protected function generate(ObjectManager $manager): void
    {
       $this->createFromArray(Milestone::class, MilestoneEnum::cases(), function (Milestone $milestone, string $value, int $key) {
           $milestone
               ->setName($value)
               ->setPlacement($key + 1)
               ->setMandatory(\random_int(0, 1))
           ;
       }, self::REFERENCE);
    }
}
