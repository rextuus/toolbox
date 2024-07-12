<?php

namespace App\Entity;

use App\TimesGame\Content\WordleStatistic\WordleStatisticRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordleStatisticRepository::class)]
class WordleStatistic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $uniqueKey = null;

    #[ORM\Column(type: Types::JSON)]
    private array $guessDistribution = [];

    #[ORM\Column(type: Types::JSON)]
    private array $streakHistory = [];

    #[ORM\Column]
    private ?int $played = null;

    #[ORM\Column]
    private ?int $won = null;

    #[ORM\Column]
    private ?int $loose = null;

    #[ORM\Column]
    private ?int $canceled = null;

    #[ORM\Column]
    private ?int $currentStreak = null;

    /**
     * @var Collection<int, Wordle>
     */
    #[ORM\ManyToMany(targetEntity: Wordle::class, inversedBy: 'wordleStatistics')]
    private Collection $wordles;

    #[ORM\OneToOne(mappedBy: 'wordleStatistic', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->wordles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniqueKey(): ?string
    {
        return $this->uniqueKey;
    }

    public function setUniqueKey(string $uniqueKey): static
    {
        $this->uniqueKey = $uniqueKey;

        return $this;
    }

    public function getGuessDistribution(): array
    {
        return $this->guessDistribution;
    }

    public function setGuessDistribution(array $guessDistribution): static
    {
        $this->guessDistribution = $guessDistribution;

        return $this;
    }

    public function getStreakHistory(): array
    {
        return $this->streakHistory;
    }

    public function setStreakHistory(array $streakHistory): WordleStatistic
    {
        $this->streakHistory = $streakHistory;
        return $this;
    }

    public function getPlayed(): ?int
    {
        return $this->played;
    }

    public function setPlayed(int $played): static
    {
        $this->played = $played;

        return $this;
    }

    public function getWon(): ?int
    {
        return $this->won;
    }

    public function setWon(int $won): static
    {
        $this->won = $won;

        return $this;
    }

    public function getLoose(): ?int
    {
        return $this->loose;
    }

    public function setLoose(int $loose): static
    {
        $this->loose = $loose;

        return $this;
    }

    public function getCanceled(): ?int
    {
        return $this->canceled;
    }

    public function setCanceled(int $canceled): static
    {
        $this->canceled = $canceled;

        return $this;
    }

    public function getCurrentStreak(): ?int
    {
        return $this->currentStreak;
    }

    public function setCurrentStreak(int $currentStreak): static
    {
        $this->currentStreak = $currentStreak;

        return $this;
    }

    /**
     * @return Collection<int, Wordle>
     */
    public function getWordles(): Collection
    {
        return $this->wordles;
    }

    public function addWordle(Wordle $wordle): static
    {
        if (!$this->wordles->contains($wordle)) {
            $this->wordles->add($wordle);
        }

        return $this;
    }

    public function removeWordle(Wordle $wordle): static
    {
        $this->wordles->removeElement($wordle);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setWordleStatistic(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getWordleStatistic() !== $this) {
            $user->setWordleStatistic($this);
        }

        $this->user = $user;

        return $this;
    }
}
