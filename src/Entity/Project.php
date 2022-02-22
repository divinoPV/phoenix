<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use App\Traits\Entity\UuidableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\{BlameableInterface, TimestampableInterface};
use Knp\DoctrineBehaviors\Model\{Blameable\BlameableTrait, Timestampable\TimestampableTrait};
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
final class Project implements TimestampableInterface, BlameableInterface
{
    use UuidableTrait, TimestampableTrait, BlameableTrait;

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

//    #[ORM\ManyToMany(targetEntity: Risk::class, inversedBy: 'projects')]
//    private ?Collection $risks;

//    #[Pure] public function __construct()
//    {
//        $this->risks = new ArrayCollection();
//    }

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

    public function getRisks(): Collection
    {
        return $this->risks;
    }

    public function addRisk(Risk $risk): self
    {
        if (!$this->risks->contains($risk)) {
            $this->risks[] = $risk;
        }

        return $this;
    }

    public function removeRisk(Risk $risk): self
    {
        $this->risks->removeElement($risk);

        return $this;
    }
}
