<?php

namespace App\Entity;

use App\Repository\OrderedStoriesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table("view_ordered_stories")]
#[ORM\Entity(repositoryClass: OrderedStoriesRepository::class, readOnly: true)]
class OrderedStories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'project_id')]
    private ?int $project = null;

    #[ORM\Column(length: 255)]
    private ?string $summary = null;

    #[ORM\Column(name: 'sprint_id', nullable: true)]
    private ?int $sprint = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $story_point = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?int
    {
        return $this->project;
    }

    public function setProject(int $project): static
    {
        $this->project = $project;

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

    public function getSprint(): ?int
    {
        return $this->sprint;
    }

    public function setSprint(?int $sprint): static
    {
        $this->sprint = $sprint;

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
