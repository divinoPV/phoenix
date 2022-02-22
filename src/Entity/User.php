<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Traits\Entity\UuidableTrait;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\{Entity\BlameableInterface, Entity\TimestampableInterface};
use Knp\DoctrineBehaviors\Model\{Blameable\BlameableTrait, Timestampable\TimestampableTrait};
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Security\Core\User\{PasswordAuthenticatedUserInterface, UserInterface};

#[ORM\Entity(repositoryClass: UserRepository::class)]
final class User implements UserInterface,
                            PasswordAuthenticatedUserInterface,
                            TimestampableInterface,
                            BlameableInterface
{
    use UuidableTrait, TimestampableTrait, BlameableTrait;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $username;

    #[ORM\Column(type: 'json')]
    private ?array $roles = [];

    #[ORM\Column(type: 'string')]
    private ?string $password;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'members')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Team $team;

    #[ORM\OneToMany(mappedBy: 'responsible', targetEntity: Portfolio::class)]
    private ?Collection $portfolios;

    #[ORM\OneToMany(mappedBy: 'responsible', targetEntity: Team::class)]
    private ?Collection $teams;

    #[Pure] public function __construct()
    {
        $this->portfolios = new ArrayCollection();
        $this->teams = new ArrayCollection();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getPortfolios(): Collection
    {
        return $this->portfolios;
    }

    public function addPortfolio(Portfolio $portfolio): self
    {
        if (!$this->portfolios->contains($portfolio)) {
            $this->portfolios[] = $portfolio;
            $portfolio->setResponsible($this);
        }

        return $this;
    }

    public function removePortfolio(Portfolio $portfolio): self
    {
        if ($this->portfolios->removeElement($portfolio)) {
            if ($portfolio->getResponsible() === $this) {
                $portfolio->setResponsible(null);
            }
        }

        return $this;
    }

    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setResponsible($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->removeElement($team)) {
            if ($team->getResponsible() === $this) {
                $team->setResponsible(null);
            }
        }

        return $this;
    }
}
