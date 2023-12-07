<?php

namespace App\Entity;

use App\Repository\OrderedStoriesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table("ordered_stories")]
#[ORM\Entity(repositoryClass: OrderedStoriesRepository::class, readOnly: true)]
class OrderedStories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $project_id = null;

    #[ORM\Column(length: 255)]
    private ?string $summary = null;

    #[ORM\Column(nullable: true)]
    private ?int $sprint_id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $story_point = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectId(): ?int
    {
        return $this->project_id;
    }

    public function setProjectId(int $project_id): static
    {
        $this->project_id = $project_id;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getSprintId(): ?int
    {
        return $this->sprint_id;
    }

    public function setSprintId(?int $sprint_id): static
    {
        $this->sprint_id = $sprint_id;

        return $this;
    }

    public function getStoryPoint(): ?int
    {
        return $this->story_point;
    }

    public function setStoryPoint(?int $story_point): static
    {
        $this->story_point = $story_point;

        return $this;
    }
}
