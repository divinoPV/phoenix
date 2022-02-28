<?php

namespace App\Entity;

use App\Repository\TeamProjectRepository;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: TeamProjectRepository::class)]
class TeamProject extends Team
{
    #[ORM\OneToMany(mappedBy: 'teamProject', targetEntity: Project::class)]
    private ?Collection $projects;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Member::class)]
    private ?Collection $members;

    #[Pure] public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->members = new ArrayCollection();
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

    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setTeam($this);
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        if ($this->members->removeElement($member)) {
            if ($member->getTeam() === $this) {
                $member->setTeam(null);
            }
        }

        return $this;
    }
}
