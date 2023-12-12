<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 3)]
    private ?string $key = null;

    #[ORM\ManyToOne]
    private ?ProjectType $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private DateTimeInterface $createdAt;

    #[ORM\Column]
    private int $currentSprintIndex = 0;

    #[ORM\ManyToOne]
    private ?User $lead = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function incrementSprintIndex() {
        $this->currentSprintIndex = $this->currentSprintIndex + 1;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    public function getType(): ?ProjectType
    {
        return $this->type;
    }

    public function setType(?ProjectType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getCurrentSprintIndex(): ?int
    {
        return $this->currentSprintIndex;
    }

    public function setCurrentSprintIndex(int $currentSprintIndex): static
    {
        $this->currentSprintIndex = $currentSprintIndex;

        return $this;
    }

    public function getLead(): ?User
    {
        return $this->lead;
    }

    public function setLead(?User $lead): static
    {
        $this->lead = $lead;

        return $this;
    }

}
