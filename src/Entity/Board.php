<?php

namespace App\Entity;

use App\Repository\BoardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoardRepository::class)
 */
class Board
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Lane::class, mappedBy="board")
     */
    private $lanes;

    public function __construct()
    {
        $this->lanes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Lane[]
     */
    public function getLanes(): Collection
    {
        return $this->lanes;
    }

    public function addLane(Lane $lane): self
    {
        if (!$this->lanes->contains($lane)) {
            $this->lanes[] = $lane;
            $lane->setBoard($this);
        }

        return $this;
    }

    public function removeLane(Lane $lane): self
    {
        if ($this->lanes->removeElement($lane)) {
            // set the owning side to null (unless already changed)
            if ($lane->getBoard() === $this) {
                $lane->setBoard(null);
            }
        }

        return $this;
    }
}
