<?php

declare(strict_types=1);

namespace App\Esc\Content\Voting;

use App\Entity\EscVoting;
use App\Esc\Content\Voting\Data\EscVotingData;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class EscVotingFactory
{
    public function createByData(EscVotingData $data): EscVoting
    {
        $escVoting = $this->createNewInstance();
        $this->mapData($data, $escVoting);
        return $escVoting;
    }

    public function mapData(EscVotingData $data, EscVoting $escVoting): EscVoting
    {
        $escVoting->setName($data->getName());
        $escVoting->setFirstChoice($data->getFirstChoice());
        $escVoting->setSecondChoice($data->getSecondChoice());
        $escVoting->setThirdChoice($data->getThirdChoice());
        $escVoting->setFirthChoice($data->getFirthChoice());
        $escVoting->setFifthChoice($data->getFifthChoice());
        $escVoting->setSixthChoice($data->getSixthChoice());
        $escVoting->setSeventhChoice($data->getSeventhChoice());
        $escVoting->setEightChoice($data->getEightChoice());
        $escVoting->setNinthChoice($data->getNinthChoice());
        $escVoting->setTenthChoice($data->getTenthChoice());
        $escVoting->setEscEvent($data->getEscEvent());

        return $escVoting;
    }

    private function createNewInstance(): EscVoting
    {
        return new EscVoting();
    }
}
