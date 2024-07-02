<?php

declare(strict_types=1);

namespace App\TimesGame\Content\Word\Data;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class WordData
{
    private string $language;
    private string $value;

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): WordData
    {
        $this->language = $language;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): WordData
    {
        $this->value = $value;
        return $this;
    }
}
