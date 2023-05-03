<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Map $map = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Status $status = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BOMatch $bOMatch = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Team $winnerTeam = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: Round::class)]
    private Collection $rounds;

    public function __construct()
    {
        $this->rounds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMap(): ?Map
    {
        return $this->map;
    }

    public function setMap(?Map $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBOMatch(): ?BOMatch
    {
        return $this->bOMatch;
    }

    public function setBOMatch(?BOMatch $bOMatch): self
    {
        $this->bOMatch = $bOMatch;

        return $this;
    }

    public function getWinnerTeam(): ?Team
    {
        return $this->winnerTeam;
    }

    public function setWinnerTeam(?Team $winnerTeam): self
    {
        $this->winnerTeam = $winnerTeam;

        return $this;
    }

    /**
     * @return Collection<int, Round>
     */
    public function getRounds(): Collection
    {
        return $this->rounds;
    }

    public function addRound(Round $round): self
    {
        if (!$this->rounds->contains($round)) {
            $this->rounds->add($round);
            $round->setGame($this);
        }

        return $this;
    }

    public function removeRound(Round $round): self
    {
        if ($this->rounds->removeElement($round)) {
            // set the owning side to null (unless already changed)
            if ($round->getGame() === $this) {
                $round->setGame(null);
            }
        }

        return $this;
    }
}
