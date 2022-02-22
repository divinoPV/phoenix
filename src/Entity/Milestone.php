<?php

namespace App\Entity;

use App\Repository\MilestoneRepository;
use App\Traits\Entity\UuidableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MilestoneRepository::class)]
final class Milestone
{
    use UuidableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $value;

    #[ORM\Column(type: 'boolean')]
    private bool $mandatory = false;

    #[ORM\OneToMany(mappedBy: 'milestone', targetEntity: Fact::class)]
    private $facts;

    public function __construct()
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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

    /**
     * @return Collection|Fact[]
     */
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
            // set the owning side to null (unless already changed)
            if ($fact->getMilestone() === $this) {
                $fact->setMilestone(null);
            }
        }

        return $this;
    }
}
