<?php

declare(strict_types=1);

namespace App\TimesGame;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class Checker
{
    /**
     * @param array<string> $search
     * @param array<string> $attempt
     */
    public function check(array $search, array $attempt): array
    {
        $states = array_fill(0, count($search), 'absent');
        $searchCharOccurrences = array_count_values($search);
        $attemptCharOccurrences = array_count_values($attempt);

        foreach ($attempt as $attemptIndex => $attemptChar) {
            $occurrenceInSearch = 0;
            if (array_key_exists($attemptChar, $searchCharOccurrences)) {
                $occurrenceInSearch = $searchCharOccurrences[$attemptChar];
            }

            if ($occurrenceInSearch === 0) {
                $states[$attemptIndex] = [$attemptChar => 'absent'];
                continue;
            }

            if ($attemptChar === $search[$attemptIndex]) {
                $states[$attemptIndex] = [$attemptChar => 'correct'];
                continue;
            }

            $states[$attemptIndex] = [$attemptChar => 'present'];
        }

        foreach ($attemptCharOccurrences as $char => $attemptCharOccurrence) {
            // check multiple used attempt chars
            if (!array_key_exists($char, $searchCharOccurrences)) {
                continue;
            }

            if ($searchCharOccurrences[$char] >= $attemptCharOccurrence) {
                continue;
            }

            $correctCount = 0;
            $presentCount = 0;
            foreach ($states as $index => $state) {
                $key = array_key_first($state);
                if ($key === $char && $state[$key] === 'correct') {
                    $correctCount++;
                }
                if ($key === $char && $state[$key] === 'present') {
                    $presentCount++;
                }
            }

            // handle presents
            if ($presentCount > $searchCharOccurrences[$char]) {
                // set all state occurence of the char which are present to absent after the first present state
                $replaced = 0;
                foreach ($states as $index => $state) {
                    $key = array_key_first($state);
                    if ($key === $char && $state[$key] === 'present') {
                        if ($replaced > 0) {
                            $states[$index] = [$char => 'absent'];
                        }
                        $replaced++;
                    }
                }
            }

            // handle corrects
            if ($correctCount === $searchCharOccurrences[$char]) {
                // replace all occurence of char which are present with absent
                foreach ($states as $index => $state) {
                        $key = array_key_first($state);
                        if ($key === $char && $state[$key] === 'present') {
                            $states[$index] = [$char => 'absent'];
                        }
                    }
            }
        }

        // let unpack the array so that we have index from 0 to 4 with states only
        $result = [];
        foreach ($states as $index => $state) {
            $result[] = $state[array_key_first($state)];
        }

        return $result;
    }
}
