<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StoryStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StoryStatusRepository::class)]
#[ApiResource]
class StoryStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    private ArrayCollection $cards ;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    public static function createById($id): StoryStatus
    {
        $status = new StoryStatus();
        $status->setId($id);
        return $status;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return ArrayCollection
     */
    public function getCards(): ArrayCollection
    {
        return $this->cards;
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
}
