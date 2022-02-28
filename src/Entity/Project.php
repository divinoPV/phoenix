<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use App\Traits\Entity\UuidableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project implements TimestampableInterface
{
    use UuidableTrait, TimestampableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $code;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $startedAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $endedAt;

    #[ORM\ManyToOne(targetEntity: Status::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Status $status;

    #[ORM\ManyToOne(targetEntity: Portfolio::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Portfolio $portfolio;

    #[ORM\ManyToOne(targetEntity: Budget::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Budget $budget;

    #[ORM\ManyToOne(targetEntity: TeamProject::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?TeamProject $teamProject;

    #[ORM\ManyToOne(targetEntity: TeamCustomer::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?TeamCustomer $teamCustomer;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: ProjectRisk::class)]
    private ?Collection $projectRisks;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Fact::class)]
    private ?Collection $facts;

    #[Pure] public function __construct()
    {
        $this->projectRisks = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(?\DateTimeImmutable $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeImmutable
    {
        return $this->endedAt;
    }

    public function setEndedAt(?\DateTimeImmutable $endedAt): self
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPortfolio(): ?Portfolio
    {
        return $this->portfolio;
    }

    public function setPortfolio(?Portfolio $portfolio): self
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    public function getBudget(): ?Budget
    {
        return $this->budget;
    }

    public function setBudget(?Budget $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getTeamProject(): ?TeamProject
    {
        return $this->teamProject;
    }

    public function setTeamProject(?TeamProject $teamProject): self
    {
        $this->teamProject = $teamProject;

        return $this;
    }

    public function getTeamCustomer(): ?TeamCustomer
    {
        return $this->teamCustomer;
    }

    public function setTeamCustomer(?TeamCustomer $teamCustomer): self
    {
        $this->teamCustomer = $teamCustomer;

        return $this;
    }
    public function getProjectRisks(): Collection
    {
        return $this->projectRisks;
    }

    public function addProjectRisk(ProjectRisk $projectRisk): self
    {
        if (!$this->projectRisks->contains($projectRisk)) {
            $this->projectRisks[] = $projectRisk;
            $projectRisk->setProject($this);
        }

        return $this;
    }

    public function removeProjectRisk(ProjectRisk $projectRisk): self
    {
        if ($this->projectRisks->removeElement($projectRisk)) {
            if ($projectRisk->getProject() === $this) {
                $projectRisk->setProject(null);
            }
        }

        return $this;
    }

    public function getFacts(): Collection
    {
        return $this->facts;
    }

    public function addFact(Fact $fact): self
    {
        if (!$this->facts->contains($fact)) {
            $this->facts[] = $fact;
            $fact->setProject($this);
        }

        return $this;
    }

    public function removeFact(Fact $fact): self
    {
        if ($this->facts->removeElement($fact)) {
            if ($fact->getProject() === $this) {
                $fact->setProject(null);
            }
        }

        return $this;
    }
}
