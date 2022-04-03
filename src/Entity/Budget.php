<?php

namespace App\Entity;

use App\Repository\BudgetRepository;
use App\Beable\Entity\Uuidable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: BudgetRepository::class)]
class Budget
{
    use Uuidable;

    #[ORM\Column(type: 'integer')]
    private ?int $original;

    #[ORM\Column(type: 'integer')]
    private ?int $consumed;

    #[ORM\Column(type: 'integer')]
    private ?int $remaining;

    #[ORM\Column(type: 'integer')]
    private ?int $landing;

    #[Pure] public function __construct(
        #[ORM\OneToMany(mappedBy: 'budget', targetEntity: Project::class)]
        private ?Collection $projects = new ArrayCollection
    ) {
    }

    public function getOriginal(): ?int
    {
        return $this->original;
    }

    public function setOriginal(int $original): static
    {
        $this->original = $original;

        return $this;
    }

    public function getConsumed(): ?int
    {
        return $this->consumed;
    }

    public function setConsumed(int $consumed): static
    {
        $this->consumed = $consumed;

        return $this;
    }

    public function getRemaining(): ?int
    {
        return $this->remaining;
    }

    public function setRemaining(int $remaining): static
    {
        $this->remaining = $remaining;

        return $this;
    }

    public function getLanding(): ?int
    {
        return $this->landing;
    }

    public function setLanding(int $landing): static
    {
        $this->landing = $landing;

        return $this;
    }

    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setBudget($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            if ($project->getBudget() === $this) {
                $project->setBudget(null);
            }
        }

        return $this;
    }
}
