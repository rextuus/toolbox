<?php

declare(strict_types=1);

namespace App\AdventCalendar;

class DoorDto
{
    public function __construct(
        public int $number,
        public string $content
    ) {}
}
