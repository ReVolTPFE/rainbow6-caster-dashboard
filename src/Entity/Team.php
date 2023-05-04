<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["user:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user:read"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user:read"])]
    private ?string $logo = null;

    #[ORM\Column(length: 5)]
    #[Groups(["user:read"])]
    private ?string $tag = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["user:read"])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'winnerTeam', targetEntity: Game::class)]
    private Collection $games;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: TeamBOMatch::class)]
    private Collection $teamBOMatches;

    #[ORM\OneToMany(mappedBy: 'winnerTeam', targetEntity: Round::class)]
    private Collection $rounds;

    #[ORM\OneToMany(mappedBy: 'winnerTeam', targetEntity: BOMatch::class)]
    private Collection $bOMatches;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->teamBOMatches = new ArrayCollection();
        $this->rounds = new ArrayCollection();
        $this->bOMatches = new ArrayCollection();
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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
            $game->setWinnerTeam($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getWinnerTeam() === $this) {
                $game->setWinnerTeam(null);
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
            $teamBOMatch->setTeam($this);
        }

        return $this;
    }

    public function removeTeamBOMatch(TeamBOMatch $teamBOMatch): self
    {
        if ($this->teamBOMatches->removeElement($teamBOMatch)) {
            // set the owning side to null (unless already changed)
            if ($teamBOMatch->getTeam() === $this) {
                $teamBOMatch->setTeam(null);
            }
        }

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
            $round->setWinnerTeam($this);
        }

        return $this;
    }

    public function removeRound(Round $round): self
    {
        if ($this->rounds->removeElement($round)) {
            // set the owning side to null (unless already changed)
            if ($round->getWinnerTeam() === $this) {
                $round->setWinnerTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BOMatch>
     */
    public function getBOMatches(): Collection
    {
        return $this->bOMatches;
    }

    public function addBOMatch(BOMatch $bOMatch): self
    {
        if (!$this->bOMatches->contains($bOMatch)) {
            $this->bOMatches->add($bOMatch);
            $bOMatch->setWinnerTeam($this);
        }

        return $this;
    }

    public function removeBOMatch(BOMatch $bOMatch): self
    {
        if ($this->bOMatches->removeElement($bOMatch)) {
            // set the owning side to null (unless already changed)
            if ($bOMatch->getWinnerTeam() === $this) {
                $bOMatch->setWinnerTeam(null);
            }
        }

        return $this;
    }
}
