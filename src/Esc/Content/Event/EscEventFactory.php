<?php

declare(strict_types=1);

namespace App\Esc\Content\Event;

use App\Entity\EscEvent;
use App\Esc\Content\Event\Data\EscEventData;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class EscEventFactory
{
    public function createByData(EscEventData $data): EscEvent
    {
        $escEvent = $this->createNewInstance();
        $this->mapData($data, $escEvent);
        return $escEvent;
    }

    public function mapData(EscEventData $data, EscEvent $escEvent): EscEvent
    {
        $escEvent->setYear($data->getYear());
        $escEvent->setCountry($data->getCountry());
        $escEvent->setCurrentlyActive($data->getCurrentlyActive());
        $escEvent->setParticipantList([]);

        return $escEvent;
    }

    private function createNewInstance(): EscEvent
    {
        return new EscEvent();
    }
}
