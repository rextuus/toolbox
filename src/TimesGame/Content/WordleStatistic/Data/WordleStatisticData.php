<?php

declare(strict_types=1);

namespace App\TimesGame\Content\WordleStatistic\Data;

use App\Entity\User;
use App\Entity\WordleStatistic;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class WordleStatisticData
{
    private string $uniqueKey;

    private array $guessDistribution = [];
    private array $streakHistory = [];

    private int $played;

    private int $won;

    private int $loose;

    private int $canceled;

    private int $currentStreak;

    private ?User $user = null;

    public function getUniqueKey(): string
    {
        return $this->uniqueKey;
    }

    public function setUniqueKey(string $uniqueKey): WordleStatisticData
    {
        $this->uniqueKey = $uniqueKey;
        return $this;
    }

    public function getGuessDistribution(): array
    {
        return $this->guessDistribution;
    }

    public function setGuessDistribution(array $guessDistribution): WordleStatisticData
    {
        $this->guessDistribution = $guessDistribution;
        return $this;
    }

    public function getStreakHistory(): array
    {
        return $this->streakHistory;
    }

    public function setStreakHistory(array $streakHistory): WordleStatisticData
    {
        $this->streakHistory = $streakHistory;
        return $this;
    }

    public function getPlayed(): int
    {
        return $this->played;
    }

    public function setPlayed(int $played): WordleStatisticData
    {
        $this->played = $played;
        return $this;
    }

    public function getWon(): int
    {
        return $this->won;
    }

    public function setWon(int $won): WordleStatisticData
    {
        $this->won = $won;
        return $this;
    }

    public function getLoose(): int
    {
        return $this->loose;
    }

    public function setLoose(int $loose): WordleStatisticData
    {
        $this->loose = $loose;
        return $this;
    }

    public function getCanceled(): int
    {
        return $this->canceled;
    }

    public function setCanceled(int $canceled): WordleStatisticData
    {
        $this->canceled = $canceled;
        return $this;
    }

    public function getCurrentStreak(): int
    {
        return $this->currentStreak;
    }

    public function setCurrentStreak(int $currentStreak): WordleStatisticData
    {
        $this->currentStreak = $currentStreak;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): WordleStatisticData
    {
        $this->user = $user;
        return $this;
    }

    public function initFromEntity(WordleStatistic $statistic): WordleStatisticData
    {
        $this->setUniqueKey($statistic->getUniqueKey());
        $this->setUser($statistic->getUser());
        $this->setGuessDistribution($statistic->getGuessDistribution());
        $this->setStreakHistory($statistic->getStreakHistory());
        $this->setPlayed($statistic->getPlayed());
        $this->setWon($statistic->getWon());
        $this->setLoose($statistic->getLoose());
        $this->setCanceled($statistic->getCanceled());
        $this->setCurrentStreak($statistic->getCurrentStreak());

        return $this;
    }
}
