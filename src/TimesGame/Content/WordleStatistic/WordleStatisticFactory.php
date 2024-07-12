<?php

declare(strict_types=1);

namespace App\TimesGame\Content\WordleStatistic;

use App\Entity\WordleStatistic;
use App\TimesGame\Content\WordleStatistic\Data\WordleStatisticData;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class WordleStatisticFactory
{
    public function createByData(WordleStatisticData $data): WordleStatistic
    {
        $wordleStatistic = $this->createNewInstance();
        $this->mapData($data, $wordleStatistic);
        return $wordleStatistic;
    }

    public function mapData(WordleStatisticData $data, WordleStatistic $wordleStatistic): WordleStatistic
    {
        $wordleStatistic->setPlayed($data->getPlayed());
        $wordleStatistic->setWon($data->getWon());
        $wordleStatistic->setLoose($data->getLoose());
        $wordleStatistic->setCanceled($data->getCanceled());
        $wordleStatistic->setCurrentStreak($data->getCurrentStreak());
        $wordleStatistic->setGuessDistribution($data->getGuessDistribution());
        $wordleStatistic->setStreakHistory($data->getStreakHistory());
        $wordleStatistic->setUniqueKey($data->getUniqueKey());

        return $wordleStatistic;
    }

    private function createNewInstance(): WordleStatistic
    {
        return new WordleStatistic();
    }
}
