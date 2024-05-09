<?php

declare(strict_types=1);

namespace App\Esc\Content\Event\Data;

use App\Entity\EscEvent;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class EscEventData
{
    private ?int $year = null;
    private ?string $country = null;
    private ?bool $currentlyActive = null;

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): EscEventData
    {
        $this->year = $year;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): EscEventData
    {
        $this->country = $country;
        return $this;
    }

    public function getCurrentlyActive(): ?bool
    {
        return $this->currentlyActive;
    }

    public function setCurrentlyActive(?bool $currentlyActive): EscEventData
    {
        $this->currentlyActive = $currentlyActive;
        return $this;
    }

    public function initFromEntity(EscEvent $event): EscEventData
    {
        $this->year = $event->getYear();
        $this->country = $event->getCountry();
        $this->currentlyActive = $event->isCurrentlyActive();

        return $this;
    }
}
