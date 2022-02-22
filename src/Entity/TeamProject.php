<?php

namespace App\Entity;

use App\Repository\TeamProjectRepository;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: TeamProjectRepository::class)]
final class TeamProject extends Team
{
    #[ORM\OneToMany(mappedBy: 'teamProject', targetEntity: Project::class)]
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
            $project->setTeamProject($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            if ($project->getTeamProject() === $this) {
                $project->setTeamProject(null);
            }
        }

        return $this;
    }
}
