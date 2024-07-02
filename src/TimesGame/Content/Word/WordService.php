<?php

declare(strict_types=1);

namespace App\TimesGame\Content\Word;

use App\Entity\TimesGameWord;
use App\TimesGame\Content\Word\Data\WordData;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class WordService
{
    public function __construct(private readonly WordRepository $repository, private readonly WordFactory $factory)
    {
    }

    public function createByData(WordData $data): TimesGameWord
    {
        $word = $this->factory->createByData($data);
        $this->repository->persist($word);
        $this->repository->flush();
        return $word;
    }

    public function update(TimesGameWord $word, WordData $data): TimesGameWord
    {
        $word = $this->factory->mapData($data, $word);
        $this->repository->persist($word);
        $this->repository->flush();
        return $word;
    }

    /**
     * @return TimesGameWord[]
     */
    public function findBy(array $conditions): array
    {
        return $this->repository->findBy($conditions);
    }

    public function isWordValidInLanguage(string $word, string $language = 'de'): bool
    {
        if ($this->repository->findOneBy(['value' => $word, 'language' => $language])){
            return true;
        }

        return false;
    }

    public function createMultipleByData(array $data): void
    {
        foreach ($data as $wordData) {
            $word = $this->factory->createByData($wordData);
            $this->repository->persist($word);
        }

        $this->repository->flush();
    }
}
