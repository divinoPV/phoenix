<?php

namespace App\Entity;

use App\Repository\BudgetRepository;
use App\Traits\Entity\UuidableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: BudgetRepository::class)]
class Budget
{
    use UuidableTrait;

    #[ORM\Column(type: 'integer')]
    private ?int $original;

    #[ORM\Column(type: 'integer')]
    private ?int $consumed;

    #[ORM\Column(type: 'integer')]
    private ?int $remaining;

    #[ORM\Column(type: 'integer')]
    private ?int $landing;

    #[ORM\OneToMany(mappedBy: 'budget', targetEntity: Project::class)]
    private ?Collection $projects;

    #[Pure] public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function getOriginal(): ?int
    {
        return $this->original;
    }

    public function setOriginal(int $original): self
    {
        $this->original = $original;

        return $this;
    }

    public function getConsumed(): ?int
    {
        return $this->consumed;
    }

    public function setConsumed(int $consumed): self
    {
        $this->consumed = $consumed;

        return $this;
    }

    public function getRemaining(): ?int
    {
        return $this->remaining;
    }

    public function setRemaining(int $remaining): self
    {
        $this->remaining = $remaining;

        return $this;
    }

    public function getLanding(): ?int
    {
        return $this->landing;
    }

    public function setLanding(int $landing): self
    {
        $this->landing = $landing;

        return $this;
    }

    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setBudget($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            if ($project->getBudget() === $this) {
                $project->setBudget(null);
            }
        }

        return $this;
    }
}
