<?php

namespace App\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidOrderedTimeGenerator;

trait UuidableTrait
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidOrderedTimeGenerator::class)]
    private ?UuidInterface $uuid = null;

    public function getUuid(): ?UuidInterface
    {
        return $this->uuid;
    }
}