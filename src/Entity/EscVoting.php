<?php

namespace App\Entity;

use App\Esc\Content\Voting\EscVotingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EscVotingRepository::class)]
class EscVoting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $firstChoice = null;
    #[ORM\Column(length: 255)]
    private ?string $secondChoice = null;
    #[ORM\Column(length: 255)]
    private ?string $thirdChoice = null;
    #[ORM\Column(length: 255)]
    private ?string $firthChoice = null;
    #[ORM\Column(length: 255)]
    private ?string $fifthChoice = null;
    #[ORM\Column(length: 255)]
    private ?string $sixthChoice = null;
    #[ORM\Column(length: 255)]
    private ?string $seventhChoice = null;
    #[ORM\Column(length: 255)]
    private ?string $eightChoice = null;
    #[ORM\Column(length: 255)]
    private ?string $ninthChoice = null;
    #[ORM\Column(length: 255)]
    private ?string $tenthChoice = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EscEvent $escEvent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstChoice(): ?string
    {
        return $this->firstChoice;
    }

    public function setFirstChoice(string $firstChoice): static
    {
        $this->firstChoice = $firstChoice;

        return $this;
    }

    public function getSecondChoice(): ?string
    {
        return $this->secondChoice;
    }

    public function setSecondChoice(?string $secondChoice): EscVoting
    {
        $this->secondChoice = $secondChoice;
        return $this;
    }

    public function getThirdChoice(): ?string
    {
        return $this->thirdChoice;
    }

    public function setThirdChoice(?string $thirdChoice): EscVoting
    {
        $this->thirdChoice = $thirdChoice;
        return $this;
    }

    public function getFirthChoice(): ?string
    {
        return $this->firthChoice;
    }

    public function setFirthChoice(?string $firthChoice): EscVoting
    {
        $this->firthChoice = $firthChoice;
        return $this;
    }

    public function getFifthChoice(): ?string
    {
        return $this->fifthChoice;
    }

    public function setFifthChoice(?string $fifthChoice): EscVoting
    {
        $this->fifthChoice = $fifthChoice;
        return $this;
    }

    public function getSixthChoice(): ?string
    {
        return $this->sixthChoice;
    }

    public function setSixthChoice(?string $sixthChoice): EscVoting
    {
        $this->sixthChoice = $sixthChoice;
        return $this;
    }

    public function getSeventhChoice(): ?string
    {
        return $this->seventhChoice;
    }

    public function setSeventhChoice(?string $seventhChoice): EscVoting
    {
        $this->seventhChoice = $seventhChoice;
        return $this;
    }

    public function getEightChoice(): ?string
    {
        return $this->eightChoice;
    }

    public function setEightChoice(?string $eightChoice): EscVoting
    {
        $this->eightChoice = $eightChoice;
        return $this;
    }

    public function getNinthChoice(): ?string
    {
        return $this->ninthChoice;
    }

    public function setNinthChoice(?string $ninthChoice): EscVoting
    {
        $this->ninthChoice = $ninthChoice;
        return $this;
    }

    public function getTenthChoice(): ?string
    {
        return $this->tenthChoice;
    }

    public function setTenthChoice(?string $tenthChoice): EscVoting
    {
        $this->tenthChoice = $tenthChoice;
        return $this;
    }

    public function getEscEvent(): ?EscEvent
    {
        return $this->escEvent;
    }

    public function setEscEvent(?EscEvent $escEvent): static
    {
        $this->escEvent = $escEvent;

        return $this;
    }
}
