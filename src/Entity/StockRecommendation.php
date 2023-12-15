<?php

namespace App\Entity;

use App\Stock\Content\Recommendation\StockRecommendationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRecommendationRepository::class)]
class StockRecommendation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $companyName = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $orderDay = null;

    #[ORM\Column]
    private ?float $valueByOrder = null;

    #[ORM\Column]
    private ?float $valueCurrent = null;

    #[ORM\OneToMany(mappedBy: 'recommendation', targetEntity: StockDailyValue::class)]
    private Collection $stockDailyValues;

    public function __construct()
    {
        $this->stockDailyValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getOrderDay(): ?\DateTimeInterface
    {
        return $this->orderDay;
    }

    public function setOrderDay(\DateTimeInterface $orderDay): static
    {
        $this->orderDay = $orderDay;

        return $this;
    }

    public function getValueByOrder(): ?float
    {
        return $this->valueByOrder;
    }

    public function setValueByOrder(float $valueByOrder): static
    {
        $this->valueByOrder = $valueByOrder;

        return $this;
    }

    public function getValueCurrent(): ?float
    {
        return $this->valueCurrent;
    }

    public function setValueCurrent(float $valueCurrent): static
    {
        $this->valueCurrent = $valueCurrent;

        return $this;
    }

    /**
     * @return Collection<int, StockDailyValue>
     */
    public function getStockDailyValues(): Collection
    {
        return $this->stockDailyValues;
    }

    public function addStockDailyValue(StockDailyValue $stockDailyValue): static
    {
        if (!$this->stockDailyValues->contains($stockDailyValue)) {
            $this->stockDailyValues->add($stockDailyValue);
            $stockDailyValue->setRecommendation($this);
        }

        return $this;
    }

    public function removeStockDailyValue(StockDailyValue $stockDailyValue): static
    {
        if ($this->stockDailyValues->removeElement($stockDailyValue)) {
            // set the owning side to null (unless already changed)
            if ($stockDailyValue->getRecommendation() === $this) {
                $stockDailyValue->setRecommendation(null);
            }
        }

        return $this;
    }
}
