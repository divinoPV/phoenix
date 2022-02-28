<?php

namespace App\Entity;

use App\Repository\FactRepository;
use App\Traits\Entity\UuidableTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactRepository::class)]
class Fact
{
    use UuidableTrait;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $occurred;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $description;

    #[ORM\ManyToOne(targetEntity: Milestone::class, inversedBy: 'facts')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Milestone $milestone;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'facts')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Project $project;

    public function getOccurred(): ?\DateTimeImmutable
    {
        return $this->occurred;
    }

    public function setOccurred(\DateTimeImmutable $occurred): self
    {
        $this->occurred = $occurred;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMilestone(): ?Milestone
    {
        return $this->milestone;
    }

    public function setMilestone(?Milestone $milestone): self
    {
        $this->milestone = $milestone;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
}
