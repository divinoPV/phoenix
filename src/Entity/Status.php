<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use App\Beable\Entity\Uuidable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Knp\DoctrineBehaviors\Contract\Entity\SluggableInterface;
use Knp\DoctrineBehaviors\Model\Sluggable\SluggableTrait;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status implements SluggableInterface
{
    use Uuidable, SluggableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $label;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $color;

    #[ORM\Column(type: 'integer')]
    private ?int $placement;

    #[Pure] public function __construct(
        #[ORM\OneToMany(mappedBy: 'status', targetEntity: Project::class)]
        private ?Collection $projects = new ArrayCollection
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

    public function getPlacement(): ?int
    {
        return $this->placement;
    }

    public function setPlacement(int $placement): static
    {
        $this->placement = $placement;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setStatus($this);
        }

        return $this;
    }

    public function getSluggableFields(): array
    {
        return ['label'];
    }

    public function generateSlugValue($values): string
    {
        return \implode('-', $values);
    }
}
