<?php

namespace App\Entity;

use App\Beable\Entity\Uuidable;
use App\Enum\TeamTypeEnum;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Knp\DoctrineBehaviors\Contract\Entity\BlameableInterface;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Blameable\BlameableTrait;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team implements TimestampableInterface, BlameableInterface
{
    use Uuidable, TimestampableTrait, BlameableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'teams')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $responsible;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'teams')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: true)]
    private ?self $parent;

    #[ORM\Column(type:'string', enumType: TeamTypeEnum::class)]
    private ?TeamTypeEnum $type;

    #[Pure] public function __construct(
        #[ORM\OneToMany(mappedBy: 'teamProject', targetEntity: Project::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
        #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
        private ?Collection $projects = new ArrayCollection,
        #[ORM\OneToMany(mappedBy: 'teamCustomer', targetEntity: Project::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
        #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
        private ?Collection $projectsCustomer = new ArrayCollection,
        #[ORM\OneToMany(mappedBy: 'team', targetEntity: User::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
        #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
        private ?Collection $members = new ArrayCollection,
        #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
        #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
        private ?Collection $teams = new ArrayCollection
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

    public function getResponsible(): ?User
    {
        return $this->responsible;
    }

    public function setResponsible(?User $responsible): static
    {
        $this->responsible = $responsible;

        return $this;
    }

    public function getParent(): ?static
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

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
            $project->setTeamProject($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            if ($project->getTeamProject() === $this) {
                $project->setTeamProject(null);
            }
        }

        return $this;
    }

    public function getProjectsCustomer(): Collection
    {
        return $this->projectsCustomer;
    }

    public function addProjectCustomer(Project $projectCustomer): static
    {
        if (!$this->projectsCustomer->contains($projectCustomer)) {
            $this->projectsCustomer[] = $projectCustomer;
            $projectCustomer->setTeamCustomer($this);
        }

        return $this;
    }

    public function removeProjectCustomer(Project $projectCustomer): static
    {
        if ($this->projectsCustomer->removeElement($projectCustomer)) {
            if ($projectCustomer->getTeamCustomer() === $this) {
                $projectCustomer->setTeamCustomer(null);
            }
        }

        return $this;
    }

    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setTeam($this);
        }

        return $this;
    }

    public function removeMember(User $member): static
    {
        if ($this->members->removeElement($member)) {
            if ($member->getTeam() === $this) {
                $member->setTeam(null);
            }
        }

        return $this;
    }

    /** @return Collection<int, static> */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(self $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setParent($this);
        }

        return $this;
    }

    public function removeTeam(self $team): static
    {
        if ($this->teams->removeElement($team)) {
            if ($team->getParent() === $this) {
                $team->setParent(null);
            }
        }

        return $this;
    }

    public function getType(): ?TeamTypeEnum
    {
        return $this->type;
    }

    public function setType(?TeamTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }
}
