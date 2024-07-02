<?php

namespace App\Entity;

use App\Repository\WordleRepository;
use App\Validator\WordleDeliveryDateIsUnique;
use App\Validator\WordleIsValidWord;
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
}
