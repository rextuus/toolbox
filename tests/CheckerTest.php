<?php

declare(strict_types=1);

namespace App\Tests;

use App\TimesGame\Checker;
use PHPUnit\Framework\TestCase;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class CheckerTest extends TestCase
{
    private Checker $checker;
    public function setUp(): void
    {
        $this->checker = new Checker();
    }

    /**
     * @dataProvider getData
     */
    public function testCheck(array $attempt, array $expected): void
    {
        $search = ['a', 'w', 'a', 's', 'h'];
        $result = $this->checker->check($search, $attempt);

        $this->assertEquals($expected, $result);
    }

    public function getData(): array
    {
        return [
            'weary' =>   [['w', 'e', 'a', 'r', 'y'], [ 'present', 'absent', 'correct', 'absent', 'absent' ]],
            'manta' =>   [['m', 'a', 'n', 't', 'a'], [ 'absent', 'present', 'absent', 'absent', 'present' ]],
            'plaza' =>   [['p', 'l', 'a', 'z', 'a'], [ 'absent', 'absent', 'correct', 'absent', 'present' ]],
            'awash' =>   [['a', 'w', 'a', 's', 'h'], [ 'correct', 'correct', 'correct', 'correct', 'correct' ]],
        ];
    }

    /**
     * @dataProvider getData2
     */
    public function testCheck2(array $attempt, array $expected): void
    {
        $search = ['k', 'r', 'e', 'i', 's'];
        $result = $this->checker->check($search, $attempt);

        $this->assertEquals($expected, $result);
    }

    public function getData2(): array
    {
        return [
            'warte' =>   [['w', 'a', 'r', 't', 'e'], [ 'absent', 'absent', 'present', 'absent', 'present' ]],
            'regen' =>   [['r', 'e', 'g', 'e', 'n'], [ 'present', 'present', 'absent', 'absent', 'absent' ]],
            'euere' =>   [['e', 'u', 'e', 'r', 'e'], [ 'absent', 'absent', 'correct', 'present', 'absent' ]],
            'kreis' =>   [['k', 'r', 'e', 'i', 's'], [ 'correct', 'correct', 'correct', 'correct', 'correct' ]],
        ];
    }

    /**
     * @dataProvider getData3
     */
    public function testCheck3(array $attempt, array $expected): void
    {
        $search = ['j', 'u', 'i', 'c', 'e'];
        $result = $this->checker->check($search, $attempt);

        $this->assertEquals($expected, $result);
    }

    public function getData3(): array
    {
        return [
            'evoke' =>   [['e', 'v', 'o', 'k', 'e'], [ 'absent', 'absent', 'absent', 'absent', 'correct' ]],
            'civic' =>   [['c', 'i', 'v', 'i', 'c'], [ 'present', 'present', 'absent', 'absent', 'absent' ]],
            'juice' =>   [['j', 'u', 'i', 'c', 'e'], [ 'correct', 'correct', 'correct', 'correct', 'correct' ]],
        ];
    }
}
