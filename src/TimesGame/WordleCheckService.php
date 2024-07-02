<?php

declare(strict_types=1);

namespace App\TimesGame;

use App\TimesGame\Content\Word\WordService;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class WordleCheckService
{

    public function __construct(private WordService $wordService, private WiktionaryService $wiktionaryService)
    {
    }

    public function isWordValid(string $word): bool
    {
        $isValid = $this->wordService->isWordValidInLanguage($word);
        if (!$isValid) {
            $isValid = $this->wiktionaryService->isPartOfGermanWiktionary(ucfirst($word));
            if (!$isValid){
                $isValid = $this->wiktionaryService->isPartOfGermanWiktionary(lcfirst($word));
            }
        }

        // englisch words
        if (!$isValid){
            $isValid = $this->wiktionaryService->isPartOfEnglischWiktionary(strtolower($word));
        }

        if ($word === ''){
            $isValid = false;
        }

        return $isValid;
    }
}
