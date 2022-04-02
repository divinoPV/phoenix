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

    #[Pure] public function __construct(
        #[ORM\OneToMany(mappedBy: 'risk', targetEntity: ProjectRisk::class)]
        private ?Collection $projectRisks = new ArrayCollection
    ) {
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

    public function getProjectRisks(): Collection
    {
        return $this->projectRisks;
    }

    public function addProjectRisk(ProjectRisk $projectRisk): static
    {
        if (!$this->projectRisks->contains($projectRisk)) {
            $this->projectRisks[] = $projectRisk;
            $projectRisk->setRisk($this);
        }

        return $this;
    }

    public function removeProjectRisk(ProjectRisk $projectRisk): static
    {
        if ($this->projectRisks->removeElement($projectRisk)) {
            if ($projectRisk->getRisk() === $this) {
                $projectRisk->setRisk(null);
            }
        }

        return $this;
    }
}
