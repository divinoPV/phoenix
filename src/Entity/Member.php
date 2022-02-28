<?php

namespace App\Entity;

use App\Repository\MembersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembersRepository::class)]
class Member extends User
{
    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'members')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: true)]
    private ?Team $team;

    #[ORM\ManyToOne(targetEntity: MemberType::class, inversedBy: 'members')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?MemberType $type;

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getType(): ?MemberType
    {
        return $this->type;
    }

    public function setType(?MemberType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
