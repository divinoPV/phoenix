<?php

namespace App\DataFixtures;

use App\Entity\MemberType;
use App\Enum\MemberTypeEnum;
use Doctrine\Persistence\ObjectManager;

final class MemberTypeFixtures extends BaseFixture
{
    public const REFERENCE = 'member-type_';

    public function generate(ObjectManager $manager): void
    {
        $this->createFromArray(MemberType::class, MemberTypeEnum::cases(), function (MemberType $memberType, string $type) {
            $memberType->setLabel($type)
                ->setColor($this->faker->hexColor());
        }, self::REFERENCE);
    }
}
