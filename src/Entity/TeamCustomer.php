<?php

namespace App\Entity;

use App\Repository\TeamCustomerRepository;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: TeamCustomerRepository::class)]
final class TeamCustomer extends Team
{
    #[ORM\OneToMany(mappedBy: 'teamCustomer', targetEntity: Project::class)]
    private ?Collection $projects;

    #[Pure] public function __construct()
    {
        parent::__construct();
        $this->projects = new ArrayCollection();
    }

    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setTeamCustomer($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            if ($project->getTeamCustomer() === $this) {
                $project->setTeamCustomer(null);
            }
        }

        return $this;
    }
}
