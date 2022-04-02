<?php

namespace App\Entity;

use App\Enum\ProbabilityEnum;
use App\Enum\SeverityEnum;
use App\Repository\RiskRepository;
use App\Beable\Entity\Uuidable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: RiskRepository::class)]
class Risk
{
    use Uuidable;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $identification;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $resolution;

    #[ORM\Column(type:'string', enumType: ProbabilityEnum::class)]
    private ?ProbabilityEnum $probability;

    #[ORM\Column(type:'string', enumType: SeverityEnum::class)]
    private ?SeverityEnum $severity;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'risks')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Project $project;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIdentification(): ?\DateTimeImmutable
    {
        return $this->identification;
    }

    public function setIdentification(\DateTimeImmutable $identification): static
    {
        $this->identification = $identification;

        return $this;
    }

    public function getResolution(): ?\DateTimeImmutable
    {
        return $this->resolution;
    }

    public function setResolution(\DateTimeImmutable $resolution): static
    {
        $this->resolution = $resolution;

        return $this;
    }

    public function getProbability(): ?ProbabilityEnum
    {
        return $this->probability;
    }

    public function setProbability(?ProbabilityEnum $probability): static
    {
        $this->probability = $probability;

        return $this;
    }

    public function getSeverity(): ?SeverityEnum
    {
        return $this->severity;
    }

    public function setSeverity(?SeverityEnum $severity): static
    {
        $this->severity = $severity;

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
