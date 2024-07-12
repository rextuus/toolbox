<?php

namespace App\Entity;

use App\Repository\WordleRepository;
use App\Validator\WordleDeliveryDateIsUnique;
use App\Validator\WordleIsValidWord;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Length;

#[\Attribute] #[ORM\Entity(repositoryClass: WordleRepository::class)]
class Wordle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5)]
    #[Length(min: 5, max: 5, minMessage: 'Your word must be exactly {{ limit }} characters long', maxMessage: 'Your word must be exactly {{ limit }} characters long')]
    #[WordleIsValidWord]
    private ?string $value = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[WordleDeliveryDateIsUnique]
    private ?\DateTimeInterface $deliveryDate = null;

    /**
     * @var Collection<int, WordleStatistic>
     */
    #[ORM\ManyToMany(targetEntity: WordleStatistic::class, mappedBy: 'wordles')]
    private Collection $wordleStatistics;

    public function __construct()
    {
        $this->wordleStatistics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(\DateTimeInterface $deliveryDate): static
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * @return Collection<int, WordleStatistic>
     */
    public function getWordleStatistics(): Collection
    {
        return $this->wordleStatistics;
    }

    public function addWordleStatistic(WordleStatistic $wordleStatistic): static
    {
        if (!$this->wordleStatistics->contains($wordleStatistic)) {
            $this->wordleStatistics->add($wordleStatistic);
            $wordleStatistic->addWordle($this);
        }

        return $this;
    }

    public function removeWordleStatistic(WordleStatistic $wordleStatistic): static
    {
        if ($this->wordleStatistics->removeElement($wordleStatistic)) {
            $wordleStatistic->removeWordle($this);
        }

        return $this;
    }
}
