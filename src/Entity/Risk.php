<?php

namespace App\Entity;

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

    #[ORM\ManyToOne(targetEntity: Probability::class, inversedBy: 'risks')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Probability $probability;

    #[ORM\ManyToOne(targetEntity: Severity::class, inversedBy: 'risks')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Severity $severity;

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

    public function getProbability(): ?Probability
    {
        return $this->probability;
    }

    public function setProbability(?Probability $probability): static
    {
        $this->probability = $probability;

        return $this;
    }

    public function getSeverity(): ?Severity
    {
        return $this->severity;
    }

    public function setSeverity(?Severity $severity): static
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
