<?php

namespace App\Entity;

use App\Repository\CasterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CasterRepository::class)]
class Caster
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["match:read", "user:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["match:read", "user:read"])]
    private ?string $nickname = null;

    #[ORM\Column(length: 255)]
    #[Groups(["match:read", "user:read"])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(["match:read", "user:read"])]
    private ?string $lastname = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["match:read", "user:read"])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'caster', targetEntity: BOMatch::class)]
    private Collection $bOMatches;

    public function __construct()
    {
        $this->bOMatches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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
            $bOMatch->setCaster($this);
        }

        return $this;
    }

    public function removeBOMatch(BOMatch $bOMatch): self
    {
        if ($this->bOMatches->removeElement($bOMatch)) {
            // set the owning side to null (unless already changed)
            if ($bOMatch->getCaster() === $this) {
                $bOMatch->setCaster(null);
            }
        }

        return $this;
    }
}
