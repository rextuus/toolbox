<?php

namespace App\Entity;

use App\Stock\Content\DailyValue\StockDailyValueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockDailyValueRepository::class)]
class StockDailyValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?float $start = null;

    #[ORM\Column]
    private ?float $final = null;

    #[ORM\Column]
    private ?float $high = null;

    #[ORM\Column]
    private ?float $low = null;

    #[ORM\ManyToOne(inversedBy: 'stockDailyValues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StockRecommendation $recommendation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getStart(): ?float
    {
        return $this->start;
    }

    public function setStart(float $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getFinal(): ?float
    {
        return $this->final;
    }

    public function setFinal(float $final): static
    {
        $this->final = $final;

        return $this;
    }

    public function getHigh(): ?float
    {
        return $this->high;
    }

    public function setHigh(float $high): static
    {
        $this->high = $high;

        return $this;
    }

    public function getLow(): ?float
    {
        return $this->low;
    }

    public function setLow(float $low): static
    {
        $this->low = $low;

        return $this;
    }

    public function getRecommendation(): ?StockRecommendation
    {
        return $this->recommendation;
    }

    public function setRecommendation(?StockRecommendation $recommendation): static
    {
        $this->recommendation = $recommendation;

        return $this;
    }
}
