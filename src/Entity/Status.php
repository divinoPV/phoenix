<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use App\Traits\Entity\UuidableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
final class Status
{
    use UuidableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $label;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $color;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $slug;

    #[ORM\Column(type: 'integer')]
    private ?int $placement;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: Project::class)]
    private ?Collection $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->setSlug();
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getPlacement(): ?int
    {
        return $this->placement;
    }

    public function setPlacement(int $placement): self
    {
        $this->placement = $placement;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    private function setSlug(): self
    {
        $this->slug = strtolower(
            trim(
                preg_replace(
                    '/[\s-]+/',
                    '-',
                    preg_replace(
                        '/[^A-Za-z0-9-]+/',
                        '-',
                        preg_replace(
                            '/[&]/',
                            'and',
                            preg_replace(
                                '/[\']/',
                                '',
                                iconv(
                                    'UTF-8',
                                    'ASCII//TRANSLIT',
                                    $this->label
                                )
                            )
                        )
                    )
                ),
                '-'
            )
        );;

        return $this;
    }

    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setStatus($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            if ($project->getStatus() === $this) {
                $project->setStatus(null);
            }
        }

        return $this;
    }
}
