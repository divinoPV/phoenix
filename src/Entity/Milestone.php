<?php

namespace App\Entity;

use App\Repository\MilestoneRepository;
use App\Traits\Entity\UuidableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: MilestoneRepository::class)]
class Milestone
{
    use UuidableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $placement;

    #[ORM\Column(type: 'boolean')]
    private bool $mandatory = false;

    #[ORM\OneToMany(mappedBy: 'milestone', targetEntity: Fact::class)]
    private ?Collection $facts;

    #[Pure] public function __construct()
    {
        $this->facts = new ArrayCollection();
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

    public function getPlacement(): ?string
    {
        return $this->placement;
    }

    public function setPlacement(string $placement): self
    {
        $this->placement = $placement;

        return $this;
    }

    public function getMandatory(): ?bool
    {
        return $this->mandatory;
    }

    public function setMandatory(bool $mandatory): self
    {
        $this->mandatory = $mandatory;

        return $this;
    }

    public function getFacts(): Collection
    {
        return $this->facts;
    }

    public function addFact(Fact $fact): self
    {
        if (!$this->facts->contains($fact)) {
            $this->facts[] = $fact;
            $fact->setMilestone($this);
        }

        return $this;
    }

    public function removeFact(Fact $fact): self
    {
        if ($this->facts->removeElement($fact)) {
            if ($fact->getMilestone() === $this) {
                $fact->setMilestone(null);
            }
        }

        return $this;
    }
}
