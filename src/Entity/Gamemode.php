<?php

namespace App\Entity;

use App\Repository\GamemodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GamemodeRepository::class)]
class Gamemode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getGamemodes"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getGamemodes"])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'gamemode', targetEntity: BOMatch::class)]
    private Collection $bOMatches;

    public function __construct()
    {
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
            $bOMatch->setGamemode($this);
        }

        return $this;
    }

    public function removeBOMatch(BOMatch $bOMatch): self
    {
        if ($this->bOMatches->removeElement($bOMatch)) {
            // set the owning side to null (unless already changed)
            if ($bOMatch->getGamemode() === $this) {
                $bOMatch->setGamemode(null);
            }
        }

        return $this;
    }
}
