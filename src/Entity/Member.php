<?php

namespace App\Entity;

use App\Enum\MemberTypeEnum;
use App\Repository\MembersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembersRepository::class)]
class Member extends User
{
    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'members')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: true)]
    private ?Team $team;

    #[ORM\Column(type:'string', enumType: MemberTypeEnum::class)]
    private ?MemberTypeEnum $type;

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }

    public function getType(): ?MemberTypeEnum
    {
        return $this->type;
    }

    public function setType(?MemberTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }
}
