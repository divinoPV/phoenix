<?php

namespace App\Entity;

use App\Repository\SeverityRepository;
use App\Traits\Entity\UuidableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: SeverityRepository::class)]
final class Severity
{
    use UuidableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $label;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $color;

    #[ORM\OneToMany(mappedBy: 'severity', targetEntity: Risk::class)]
    private ?Collection $risks;

    #[Pure] public function __construct()
    {
        $this->risks = new ArrayCollection();
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getRisks(): Collection
    {
        return $this->risks;
    }

    public function addRisk(Risk $risk): self
    {
        if (!$this->risks->contains($risk)) {
            $this->risks[] = $risk;
            $risk->setSeverity($this);
        }

        return $this;
    }

    public function removeRisk(Risk $risk): self
    {
        if ($this->risks->removeElement($risk)) {
            if ($risk->getSeverity() === $this) {
                $risk->setSeverity(null);
            }
        }

        return $this;
    }
}
