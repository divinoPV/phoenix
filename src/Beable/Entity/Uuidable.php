<?php

namespace App\Beable\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidOrderedTimeGenerator;

trait Uuidable
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidOrderedTimeGenerator::class)]
    private UuidInterface|string|null $uuid = null;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }
}
