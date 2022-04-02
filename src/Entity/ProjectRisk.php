<?php

namespace App\Entity;

use App\Repository\ProjectRiskRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

#[ORM\Entity(repositoryClass: ProjectRiskRepository::class)]
class ProjectRisk implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'projectRisks')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Project $project;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Risk::class, inversedBy: 'projectRisks')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Risk $risk;

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getRisk(): ?Risk
    {
        return $this->risk;
    }

    public function setRisk(?Risk $risk): static
    {
        $this->risk = $risk;

        return $this;
    }
}
