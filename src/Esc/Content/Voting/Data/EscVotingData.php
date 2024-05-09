<?php

declare(strict_types=1);

namespace App\Esc\Content\Voting\Data;

use App\Entity\EscEvent;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class EscVotingData
{
    private ?string $name = null;
    private ?string $firstChoice = null;
    private ?string $secondChoice = null;
    private ?string $thirdChoice = null;
    private ?string $firthChoice = null;
    private ?string $fifthChoice = null;
    private ?string $sixthChoice = null;
    private ?string $seventhChoice = null;
    private ?string $eightChoice = null;
    private ?string $ninthChoice = null;
    private ?string $tenthChoice = null;
    private ?EscEvent $escEvent = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): EscVotingData
    {
        $this->name = $name;
        return $this;
    }

    public function getFirstChoice(): ?string
    {
        return $this->firstChoice;
    }

    public function setFirstChoice(?string $firstChoice): EscVotingData
    {
        $this->firstChoice = $firstChoice;
        return $this;
    }

    public function getSecondChoice(): ?string
    {
        return $this->secondChoice;
    }

    public function setSecondChoice(?string $secondChoice): EscVotingData
    {
        $this->secondChoice = $secondChoice;
        return $this;
    }

    public function getThirdChoice(): ?string
    {
        return $this->thirdChoice;
    }

    public function setThirdChoice(?string $thirdChoice): EscVotingData
    {
        $this->thirdChoice = $thirdChoice;
        return $this;
    }

    public function getFirthChoice(): ?string
    {
        return $this->firthChoice;
    }

    public function setFirthChoice(?string $firthChoice): EscVotingData
    {
        $this->firthChoice = $firthChoice;
        return $this;
    }

    public function getFifthChoice(): ?string
    {
        return $this->fifthChoice;
    }

    public function setFifthChoice(?string $fifthChoice): EscVotingData
    {
        $this->fifthChoice = $fifthChoice;
        return $this;
    }

    public function getSixthChoice(): ?string
    {
        return $this->sixthChoice;
    }

    public function setSixthChoice(?string $sixthChoice): EscVotingData
    {
        $this->sixthChoice = $sixthChoice;
        return $this;
    }

    public function getSeventhChoice(): ?string
    {
        return $this->seventhChoice;
    }

    public function setSeventhChoice(?string $seventhChoice): EscVotingData
    {
        $this->seventhChoice = $seventhChoice;
        return $this;
    }

    public function getEightChoice(): ?string
    {
        return $this->eightChoice;
    }

    public function setEightChoice(?string $eightChoice): EscVotingData
    {
        $this->eightChoice = $eightChoice;
        return $this;
    }

    public function getNinthChoice(): ?string
    {
        return $this->ninthChoice;
    }

    public function setNinthChoice(?string $ninthChoice): EscVotingData
    {
        $this->ninthChoice = $ninthChoice;
        return $this;
    }

    public function getTenthChoice(): ?string
    {
        return $this->tenthChoice;
    }

    public function setTenthChoice(?string $tenthChoice): EscVotingData
    {
        $this->tenthChoice = $tenthChoice;
        return $this;
    }

    public function getEscEvent(): ?EscEvent
    {
        return $this->escEvent;
    }

    public function setEscEvent(?EscEvent $escEvent): EscVotingData
    {
        $this->escEvent = $escEvent;
        return $this;
    }
}
