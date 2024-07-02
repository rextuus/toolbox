<?php

declare(strict_types=1);

namespace App\TimesGame\Content\Word;

use App\Entity\TimesGameWord;
use App\TimesGame\Content\Word\Data\WordData;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class WordFactory
{
    public function createByData(WordData $data): TimesGameWord
    {
        $word = $this->createNewInstance();
        $this->mapData($data, $word);
        return $word;
    }

    public function mapData(WordData $data, TimesGameWord $word): TimesGameWord
    {
        $word->setLanguage($data->getLanguage());
        $word->setValue($data->getValue());

        return $word;
    }

    private function createNewInstance(): TimesGameWord
    {
        return new TimesGameWord();
    }
}
