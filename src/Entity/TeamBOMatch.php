<?php

namespace App\Entity;

use App\Repository\TeamBOMatchRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamBOMatchRepository::class)]
class TeamBOMatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'teamBOMatches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team = null;

    #[ORM\ManyToOne(inversedBy: 'teamBOMatches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BOMatch $bOMatch = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

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
}
