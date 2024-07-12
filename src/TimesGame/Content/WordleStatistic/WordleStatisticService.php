<?php

declare(strict_types=1);

namespace App\TimesGame\Content\WordleStatistic;

use App\Entity\User;
use App\Entity\WordleStatistic;
use App\Repository\WordleRepository;
use App\TimesGame\Content\WordleStatistic\Data\WordleStatisticData;
use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2024 DocCheck Community GmbH
 */
class WordleStatisticService
{
    public const KEY_UNIQUE_ID = 'uniqueId';
    public const KEY_USED_ATTEMPTS = 'usedAttempts';
    public const KEY_WORDLE_ID = 'wordleId';
    public const KEY_RESULT = 'result';

    public function __construct(
        private readonly WordleStatisticRepository $repository,
        private readonly WordleStatisticFactory $factory,
        private readonly WordleRepository $wordleRepository,
    ) {
    }

    public function createByData(WordleStatisticData $data): WordleStatistic
    {
        $wordleStatistic = $this->factory->createByData($data);

        if ($data->getUser()){
            $data->getUser()->setWordleStatistic($wordleStatistic);
        }

        $this->repository->save($wordleStatistic);
        return $wordleStatistic;
    }

    public function update(WordleStatistic $wordleStatistic, WordleStatisticData $data): WordleStatistic
    {
        $wordleStatistic = $this->factory->mapData($data, $wordleStatistic);
        $this->repository->save($wordleStatistic);
        return $wordleStatistic;
    }

    /**
     * @return WordleStatistic[]
     */
    public function findBy(array $conditions): array
    {
        return $this->repository->findBy($conditions);
    }

    public function findByUniqueKey(string $uniqueKey): ?WordleStatistic
    {
        return $this->repository->findOneBy(['uniqueKey' => $uniqueKey]);
    }

    public function findByUser(UserInterface $user): ?WordleStatistic
    {
        return $this->repository->findOneBy(['user' => $user]);
    }

    public function save(array $data, ?UserInterface $user, string $uniqueId): bool
    {
        $attempts = (int)$data[self::KEY_USED_ATTEMPTS];
        $wordleId = (int)$data[self::KEY_WORDLE_ID];
        $result = (bool)$data[self::KEY_RESULT];

        $currentWordle = $this->wordleRepository->find($wordleId);
        if (!$currentWordle) {
            return false;
        }

        $currentDate = new DateTime();
        $deliveryDate = $currentWordle->getDeliveryDate();

        if ($currentDate->format('Y-m-d') !== $deliveryDate->format('Y-m-d')) {
            return false;
        }

        $statistic = $this->findByUniqueKey($uniqueId);

        // create fresh statistic
        if ($statistic === null) {
            $data = $this->initEmptyStatisticData($uniqueId, $result, $wordleId, $attempts, $user);
            $this->createByData($data);

            return false;
        }

        // update existing one
        $data = (new WordleStatisticData())->initFromEntity($statistic);

        $distribution = $data->getGuessDistribution();

        // break if wordle is already played
        if (array_key_exists($wordleId, $distribution)) {
            return false;
        }

        $distribution[$wordleId] = $attempts;

        $data->setLoose($data->getLoose() + ($result ? 0 : 1));
        $data->setWon($data->getWon() + ($result ? 1 : 0));

        // streak handling
        if ($result) {
            $lastActiveWordle = $this->wordleRepository->findLastActiveBeforeCurrent($deliveryDate);
            if ($lastActiveWordle !== null && array_key_exists($lastActiveWordle->getId(), $distribution) && $distribution[$lastActiveWordle->getId()] !== 0) {
                $data->setCurrentStreak($data->getCurrentStreak() + 1);
            }else{
                $data->setCurrentStreak(1);
            }
        } else {
            $streakHistory = $data->getStreakHistory();
            $streakHistory[] = $data->getCurrentStreak();
            $data->setCurrentStreak(0);
            $data->setStreakHistory($streakHistory);
            $distribution[$wordleId] = 0;
        }
        $data->setGuessDistribution($distribution);

        $data->setPlayed($data->getPlayed() + 1);

        // user is logged in and statistic hasnt a reference yet => use the logged in user: TODO ask user to do that
        if ($user instanceof User && $data->getUser() === null) {
            $data->setUser($user);
        }

        $this->update($statistic, $data);

        return true;
    }

    private function initEmptyStatisticData(
        string $uniqueId,
        bool $result,
        int $wordleId,
        int $attempts,
        ?UserInterface $user
    ): WordleStatisticData {
        $data = new WordleStatisticData();

        $data->setUniqueKey($uniqueId);
        $data->setLoose($result ? 0 : 1);
        $data->setWon($result ? 1 : 0);
        $data->setCurrentStreak($result ? 1 : 0);
        $data->setCanceled(0);
        $data->setPlayed(1);
        if (!$result) {
            $attempts = 0;
        }
        $data->setGuessDistribution([$wordleId => $attempts]);
        $data->setStreakHistory([]);

        if ($user instanceof User) {
            $data->setUser($user);
        }

        return $data;
    }
}
