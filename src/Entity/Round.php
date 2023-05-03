<?php

namespace App\Entity;

use App\Repository\RoundRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoundRepository::class)]
class Round
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $roundNumber = null;

    #[ORM\ManyToOne(inversedBy: 'rounds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'rounds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $winnerTeam = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoundNumber(): ?int
    {
        return $this->roundNumber;
    }

    public function setRoundNumber(int $roundNumber): self
    {
        $this->roundNumber = $roundNumber;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

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
}
