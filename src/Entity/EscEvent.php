<?php

namespace App\Entity;

use App\Esc\Content\Event\EscEventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EscEventRepository::class)]
class EscEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    /**
     * @var Collection<int, EscVoting>
     */
    #[ORM\OneToMany(mappedBy: 'escEvent', targetEntity: EscVoting::class, orphanRemoval: true)]
    private Collection $votes;

    #[ORM\Column]
    private ?bool $currentlyActive = null;

    #[ORM\Column(type: 'json')]
    private array $participantList = [];

    public function __construct()
    {
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, EscVoting>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(EscVoting $vote): static
    {
        if (!$this->votes->contains($vote)) {
            $this->votes->add($vote);
            $vote->setEscEvent($this);
        }

        return $this;
    }

    public function removeVote(EscVoting $vote): static
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getEscEvent() === $this) {
                $vote->setEscEvent(null);
            }
        }

        return $this;
    }

    public function isCurrentlyActive(): ?bool
    {
        return $this->currentlyActive;
    }

    public function setCurrentlyActive(bool $isCurrentlyActive): static
    {
        $this->currentlyActive = $isCurrentlyActive;

        return $this;
    }

    public function getParticipantList(): array
    {
        return $this->participantList;
    }

    public function setParticipantList(array $participantList): static
    {
        $this->participantList = $participantList;

        return $this;
    }
}
