<?php

namespace App\Entity;

use App\Repository\ResponsibleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: ResponsibleRepository::class)]
class Responsible extends User
{
    #[Pure] public function __construct(
        #[ORM\OneToMany(mappedBy: 'responsible', targetEntity: Portfolio::class)]
        private ?Collection $portfolios = new ArrayCollection,
        #[ORM\OneToMany(mappedBy: 'responsible', targetEntity: Team::class)]
        private ?Collection $teams = new ArrayCollection
    ) {
    }

    public function getPortfolios(): Collection
    {
        return $this->portfolios;
    }

    public function addPortfolio(Portfolio $portfolio): static
    {
        if (!$this->portfolios->contains($portfolio)) {
            $this->portfolios[] = $portfolio;
            $portfolio->setResponsible($this);
        }

        return $this;
    }

    public function removePortfolio(Portfolio $portfolio): static
    {
        if ($this->portfolios->removeElement($portfolio)) {
            if ($portfolio->getResponsible() === $this) {
                $portfolio->setResponsible(null);
            }
        }

        return $this;
    }

    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setResponsible($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            if ($team->getResponsible() === $this) {
                $team->setResponsible(null);
            }
        }

        return $this;
    }
}
