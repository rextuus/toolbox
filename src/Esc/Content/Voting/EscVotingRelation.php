<?php

namespace App\Esc\Content\Voting;

enum EscVotingRelation: string
{
    case FIRST = 'first';
    case SECOND = 'second';
    case THIRD = 'third';
    case FOURTH = 'fourth';
    case FIFTH = 'fifth';
    case SIXTH = 'sixth';
    case SEVENTH = 'seventh';
    case EIGHT = 'eight';
    case NINTH = 'ninth';
    case TENTH = 'tenth';

    public function getGetterForEscChoice(): string
    {
        return match ($this) {
            self::FIRST => 'getFirstChoice',
            self::SECOND => 'getSecondChoice',
            self::THIRD => 'getThirdChoice',
            self::FOURTH => 'getFirthChoice',
            self::FIFTH => 'getFifthChoice',
            self::SIXTH => 'getSixthChoice',
            self::SEVENTH => 'getSeventhChoice',
            self::EIGHT => 'getEightChoice',
            self::NINTH => 'getNinthChoice',
            self::TENTH => 'getTenthChoice',
            default => throw new \Exception('Unexpected match value'),
        };
    }
}
