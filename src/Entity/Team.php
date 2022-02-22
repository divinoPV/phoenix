<?php

namespace App\Entity;

use App\Traits\Entity\UuidableTrait;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use JetBrains\PhpStorm\Pure;

#[MappedSuperclass]
abstract class Team
{
    use UuidableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'teams')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?User $responsible;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: User::class)]
    private ?Collection $members;

    #[Pure] public function __construct()
    {
        $this->members = new ArrayCollection();
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

    public function getResponsible(): ?User
    {
        return $this->responsible;
    }

    public function setResponsible(?User $responsible): self
    {
        $this->responsible = $responsible;

        return $this;
    }

    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setTeam($this);
        }

        return $this;
    }

    public function removeMember(User $member): self
    {
        if ($this->members->removeElement($member)) {
            if ($member->getTeam() === $this) {
                $member->setTeam(null);
            }
        }

        return $this;
    }
}
