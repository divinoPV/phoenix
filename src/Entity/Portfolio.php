<?php

namespace App\Entity;

use App\Repository\PortfolioRepository;
use App\Beable\Entity\Uuidable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: PortfolioRepository::class)]
class Portfolio
{
    use Uuidable;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\ManyToOne(targetEntity: Responsible::class, inversedBy: 'portfolios')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Responsible $responsible;

    #[Pure] public function __construct(
        #[ORM\OneToMany(mappedBy: 'portfolio', targetEntity: Project::class)]
        private ?Collection $projects = new ArrayCollection
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

    public function getResponsible(): ?Responsible
    {
        return $this->responsible;
    }

    public function setResponsible(?Responsible $responsible): static
    {
        $this->responsible = $responsible;

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
            $project->setPortfolio($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            if ($project->getPortfolio() === $this) {
                $project->setPortfolio(null);
            }
        }

        return $this;
    }
}
