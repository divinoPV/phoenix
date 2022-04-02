<?php

namespace App\Entity;

use App\Repository\MemberTypeRepository;
use App\Beable\Entity\Uuidable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: MemberTypeRepository::class)]
class MemberType
{
    use Uuidable;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $label;

    #[ORM\Column(type: 'string', length: 7)]
    private ?string $color;

    #[Pure] public function __construct(
        #[ORM\OneToMany(mappedBy: 'type', targetEntity: Member::class)]
        private ?Collection $members = new ArrayCollection
    ) {
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setType($this);
        }

        return $this;
    }

    public function removeMember(Member $member): static
    {
        if ($this->members->removeElement($member)) {
            if ($member->getType() === $this) {
                $member->setType(null);
            }
        }

        return $this;
    }
}
