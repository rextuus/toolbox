<?php

declare(strict_types=1);

namespace App\Esc\Content\Voting;

use App\Entity\EscVoting;
use App\Esc\Content\Voting\Data\EscVotingData;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class EscVotingService
{
    public function __construct(private readonly EscVotingRepository $repository, private readonly EscVotingFactory $factory)
    {
    }

    public function createByData(EscVotingData $data): EscVoting
    {
        $escVoting = $this->factory->createByData($data);
        $this->repository->persist($escVoting);
        return $escVoting;
    }

    public function update(EscVoting $escVoting, EscVotingData $data): EscVoting
    {
        $escVoting = $this->factory->mapData($data, $escVoting);
        $this->repository->persist($escVoting);
        return $escVoting;
    }

    /**
     * @return EscVoting[]
     */
    public function findBy(array $conditions): array
    {
        return $this->repository->findBy($conditions);
    }
}
