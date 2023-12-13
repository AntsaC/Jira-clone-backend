<?php

namespace App\Entity;

use App\Repository\UserStoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserStoryRepository::class)]
class UserStory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 300)]
    private ?string $summary = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    #[ORM\ManyToOne]
    private ?Sprint $sprint = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $storyPoint = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $previous = null;

    #[ORM\ManyToOne]
    private ?StoryStatus $status = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getSprint(): ?Sprint
    {
        return $this->sprint;
    }

    public function setSprint(?Sprint $sprint): static
    {
        $this->sprint = $sprint;

        return $this;
    }

    public function getStoryPoint(): ?int
    {
        return $this->storyPoint;
    }

    public function setStoryPoint(?int $storyPoint): static
    {
        $this->storyPoint = $storyPoint;

        return $this;
    }

    public function getPrevious(): ?self
    {
        return $this->previous;
    }

    public function setPrevious(?self $previous): static
    {
        $this->previous = $previous;

        return $this;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getStatus(): ?StoryStatus
    {
        return $this->status;
    }

    public function setStatus(?StoryStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}
