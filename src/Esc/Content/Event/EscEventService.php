<?php

declare(strict_types=1);

namespace App\Esc\Content\Event;

use App\Entity\EscEvent;
use App\Esc\Content\Event\Data\EscEventData;
use Exception;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class EscEventService
{
    public function __construct(private readonly EscEventRepository $repository, private readonly EscEventFactory $factory)
    {
    }

    public function createByData(EscEventData $data): EscEvent
    {
        $escEvent = $this->factory->createByData($data);
        $this->repository->persist($escEvent);
        return $escEvent;
    }

    public function update(EscEvent $escEvent, EscEventData $data): EscEvent
    {
        $escEvent = $this->factory->mapData($data, $escEvent);
        $this->repository->persist($escEvent);
        return $escEvent;
    }

    /**
     * @return EscEvent[]
     */
    public function findBy(array $conditions): array
    {
        return $this->repository->findBy($conditions);
    }

    /**
     * @throws Exception
     */
    public function getCurrentlyActiveEvent (): EscEvent
    {
        $event = $this->repository->findOneBy(['currentlyActive' => true]);

        if (null === $event) {
            throw new Exception('There is no active esc event');
        }

        return $event;
    }
}
