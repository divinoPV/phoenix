<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use App\Beable\Entity\Uuidable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\BlameableInterface;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Blameable\BlameableTrait;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project implements TimestampableInterface, BlameableInterface
{
    use Uuidable, TimestampableTrait, BlameableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $code;

    #[ORM\Column(type: 'boolean')]
    private bool $archived;

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

    #[ORM\ManyToOne(targetEntity: Budget::class, cascade: ['persist'], inversedBy: 'projects')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Budget $budget;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Team $teamProject;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'projectsCustomer')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Team $teamCustomer;

    #[Pure] public function __construct(
        #[ORM\OneToMany(mappedBy: 'project', targetEntity: Risk::class, cascade: ['persist', 'remove'])]
        private ?Collection $risks = new ArrayCollection,
        #[ORM\OneToMany(mappedBy: 'project', targetEntity: Fact::class, cascade: ['persist', 'remove'])]
        private ?Collection $facts = new ArrayCollection
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function hasArchived(): bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): static
    {
        $this->archived = $archived;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(?\DateTimeImmutable $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeImmutable
    {
        return $this->endedAt;
    }

    public function setEndedAt(?\DateTimeImmutable $endedAt): static
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

    public function setPortfolio(?Portfolio $portfolio): static
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    public function getBudget(): ?Budget
    {
        return $this->budget;
    }

    public function setBudget(?Budget $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getTeamProject(): ?Team
    {
        return $this->teamProject;
    }

    public function setTeamProject(?Team $teamProject): static
    {
        $this->teamProject = $teamProject;

        return $this;
    }

    public function getTeamCustomer(): ?Team
    {
        return $this->teamCustomer;
    }

    public function setTeamCustomer(?Team $teamCustomer): static
    {
        $this->teamCustomer = $teamCustomer;

        return $this;
    }
    public function getRisks(): Collection
    {
        return $this->risks;
    }

    public function addRisk(Risk $risk): static
    {
        if (!$this->risks->contains($risk)) {
            $this->risks[] = $risk;
            $risk->setProject($this);
        }

        return $this;
    }

    public function removeRisk(Risk $risk): static
    {
        if ($this->risks->removeElement($risk)) {
            if ($risk->getProject() === $this) {
                $risk->setProject(null);
            }
        }

        return $this;
    }

    public function getFacts(): Collection
    {
        return $this->facts;
    }

    public function addFact(Fact $fact): static
    {
        if (!$this->facts->contains($fact)) {
            $this->facts[] = $fact;
            $fact->setProject($this);
        }

        return $this;
    }

    public function removeFact(Fact $fact): static
    {
        if ($this->facts->removeElement($fact)) {
            if ($fact->getProject() === $this) {
                $fact->setProject(null);
            }
        }

        return $this;
    }
}
