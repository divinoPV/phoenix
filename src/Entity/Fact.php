<?php

namespace App\Entity;

use App\Enum\MilestoneEnum;
use App\Repository\FactRepository;
use App\Beable\Entity\Uuidable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactRepository::class)]
class Fact
{
    use Uuidable;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $occurred;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $description;

    #[ORM\Column(type:'string', enumType: MilestoneEnum::class)]
    private ?MilestoneEnum $milestone;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'facts')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Project $project;

    public function getOccurred(): ?\DateTimeImmutable
    {
        return $this->occurred;
    }

    public function setOccurred(\DateTimeImmutable $occurred): static
    {
        $this->occurred = $occurred;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMilestone(): ?MilestoneEnum
    {
        return $this->milestone;
    }

    public function setMilestone(?MilestoneEnum $milestone): static
    {
        $this->milestone = $milestone;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }
}
