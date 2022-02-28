<?php

namespace App\Entity;

use App\Repository\RiskRepository;
use App\Traits\Entity\UuidableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: RiskRepository::class)]
class Risk
{
    use UuidableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $identification;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $resolution;

    #[ORM\ManyToOne(targetEntity: Probability::class, inversedBy: 'risks')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Probability $probability;

    #[ORM\ManyToOne(targetEntity: Severity::class, inversedBy: 'risks')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Severity $severity;

    #[ORM\OneToMany(mappedBy: 'risk', targetEntity: ProjectRisk::class)]
    private ?Collection $projectRisks;

    #[Pure] public function __construct()
    {
        $this->projectRisks = new ArrayCollection();
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

    public function getIdentification(): ?\DateTimeImmutable
    {
        return $this->identification;
    }

    public function setIdentification(\DateTimeImmutable $identification): self
    {
        $this->identification = $identification;

        return $this;
    }

    public function getResolution(): ?\DateTimeImmutable
    {
        return $this->resolution;
    }

    public function setResolution(\DateTimeImmutable $resolution): self
    {
        $this->resolution = $resolution;

        return $this;
    }

    public function getProbability(): ?Probability
    {
        return $this->probability;
    }

    public function setProbability(?Probability $probability): self
    {
        $this->probability = $probability;

        return $this;
    }

    public function getSeverity(): ?Severity
    {
        return $this->severity;
    }

    public function setSeverity(?Severity $severity): self
    {
        $this->severity = $severity;

        return $this;
    }

    public function getProjectRisks(): Collection
    {
        return $this->projectRisks;
    }

    public function addProjectRisk(ProjectRisk $projectRisk): self
    {
        if (!$this->projectRisks->contains($projectRisk)) {
            $this->projectRisks[] = $projectRisk;
            $projectRisk->setRisk($this);
        }

        return $this;
    }

    public function removeProjectRisk(ProjectRisk $projectRisk): self
    {
        if ($this->projectRisks->removeElement($projectRisk)) {
            if ($projectRisk->getRisk() === $this) {
                $projectRisk->setRisk(null);
            }
        }

        return $this;
    }
}
