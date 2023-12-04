<?php

namespace App\Entity;

use App\Repository\CriteriaAcceptanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CriteriaAcceptanceRepository::class)]
class CriteriaAcceptance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $criteria = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserStory $userStory = null;

    #[ORM\Column]
    private ?bool $checked = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCriteria(): ?string
    {
        return $this->criteria;
    }

    public function setCriteria(string $criteria): static
    {
        $this->criteria = $criteria;

        return $this;
    }

    public function getUserStory(): ?UserStory
    {
        return $this->userStory;
    }

    public function setUserStory(?UserStory $userStory): static
    {
        $this->userStory = $userStory;

        return $this;
    }

    public function isChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(bool $checked): static
    {
        $this->checked = $checked;

        return $this;
    }
}
