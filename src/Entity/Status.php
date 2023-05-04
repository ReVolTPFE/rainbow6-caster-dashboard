<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getStatuses"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getStatuses"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getStatuses"])]
    private ?string $colorCode = null;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: Game::class)]
    private Collection $games;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: BOMatch::class)]
    private Collection $bOMatches;

    public function __construct()
    {
        $this->games = new ArrayCollection();
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

    public function getColorCode(): ?string
    {
        return $this->colorCode;
    }

    public function setColorCode(string $colorCode): self
    {
        $this->colorCode = $colorCode;

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
            $game->setStatus($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getStatus() === $this) {
                $game->setStatus(null);
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
            $bOMatch->setStatus($this);
        }

        return $this;
    }

    public function removeBOMatch(BOMatch $bOMatch): self
    {
        if ($this->bOMatches->removeElement($bOMatch)) {
            // set the owning side to null (unless already changed)
            if ($bOMatch->getStatus() === $this) {
                $bOMatch->setStatus(null);
            }
        }

        return $this;
    }
}
