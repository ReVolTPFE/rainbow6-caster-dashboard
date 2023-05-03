<?php

namespace App\Entity;

use App\Repository\BOMatchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BOMatchRepository::class)]
class BOMatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'bOMatches')]
    private ?Status $status = null;

    #[ORM\ManyToOne(inversedBy: 'bOMatches')]
    private ?Gamemode $gamemode = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private array $banMap = [];

    #[ORM\OneToMany(mappedBy: 'bOMatch', targetEntity: Game::class, orphanRemoval: true)]
    private Collection $games;

    #[ORM\OneToMany(mappedBy: 'bOMatch', targetEntity: TeamBOMatch::class)]
    private Collection $teamBOMatches;

    #[ORM\ManyToOne(inversedBy: 'bOMatches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Caster $caster = null;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->teamBOMatches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getGamemode(): ?Gamemode
    {
        return $this->gamemode;
    }

    public function setGamemode(?Gamemode $gamemode): self
    {
        $this->gamemode = $gamemode;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getBanMap(): array
    {
        return $this->banMap;
    }

    public function setBanMap(array $banMap): self
    {
        $this->banMap = $banMap;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setBOMatch($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getBOMatch() === $this) {
                $game->setBOMatch(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TeamBOMatch>
     */
    public function getTeamBOMatches(): Collection
    {
        return $this->teamBOMatches;
    }

    public function addTeamBOMatch(TeamBOMatch $teamBOMatch): self
    {
        if (!$this->teamBOMatches->contains($teamBOMatch)) {
            $this->teamBOMatches->add($teamBOMatch);
            $teamBOMatch->setBOMatch($this);
        }

        return $this;
    }

    public function removeTeamBOMatch(TeamBOMatch $teamBOMatch): self
    {
        if ($this->teamBOMatches->removeElement($teamBOMatch)) {
            // set the owning side to null (unless already changed)
            if ($teamBOMatch->getBOMatch() === $this) {
                $teamBOMatch->setBOMatch(null);
            }
        }

        return $this;
    }

    public function getCaster(): ?Caster
    {
        return $this->caster;
    }

    public function setCaster(?Caster $caster): self
    {
        $this->caster = $caster;

        return $this;
    }
}
