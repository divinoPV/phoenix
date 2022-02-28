<?php

namespace App\Entity;

use App\Traits\Entity\UuidableTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class Team
{
    use UuidableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\ManyToOne(targetEntity: Responsible::class, inversedBy: 'teams')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Responsible $responsible;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getResponsible(): ?Responsible
    {
        return $this->responsible;
    }

    public function setResponsible(?Responsible $responsible): self
    {
        $this->responsible = $responsible;

        return $this;
    }
}
