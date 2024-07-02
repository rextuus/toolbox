<?php

declare(strict_types=1);

namespace App\TimesGame;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class WiktionaryService
{
    public function __construct(private HttpClientInterface $client,)
    {
    }

    public function isPartOfGermanWiktionary(string $word): bool
    {
        $response = $this->client->request(
            'GET',
            'https://de.m.wiktionary.org/wiki/' . $word
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode === 404) {
            return false;
        }

        return true;
    }

    public function isPartOfEnglischWiktionary(string $word): bool
    {
        $response = $this->client->request(
            'GET',
            'https://en.m.wiktionary.org/wiki/' . $word
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode === 404) {
            return false;
        }

        return true;
    }
}
