<?php

namespace App\Entity;

use App\Beable\Entity\Uuidable;
use App\Repository\TeamTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: TeamTypeRepository::class)]
class TeamType
{
    use Uuidable;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $label;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Team::class)]
    private ?Collection $teams;

    #[Pure] public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /** @return Collection<int, Team> */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setType($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            if ($team->getType() === $this) {
                $team->setType(null);
            }
        }

        return $this;
    }
}
