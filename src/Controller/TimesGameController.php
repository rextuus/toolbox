<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\WordleRepository;
use App\TimesGame\Content\WordleStatistic\WordleStatisticService;
use App\TimesGame\WordleCheckService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/times/game')]
class TimesGameController extends AbstractController
{
    private const NEEDED_KEYS = [
        WordleStatisticService::KEY_USED_ATTEMPTS,
        WordleStatisticService::KEY_WORDLE_ID,
        WordleStatisticService::KEY_RESULT,
    ];

    public function __construct(private WordleStatisticService $statisticService)
    {
    }

    #[Route('/', name: 'app_times_game')]
    public function index(Request $request, WordleRepository $wordleRepository): Response
    {
        $user = $this->getUser();

        $currentDate = new DateTime();
        $currentDate->setTime(0, 0, 0);
        $dailyWordle = $wordleRepository->findBy(['deliveryDate' => $currentDate]);

        $wordle = 'teste';
        $id = 0;
        if (count($dailyWordle)) {
            $wordle = strtolower($dailyWordle[0]->getValue());
            $id = $dailyWordle[0]->getId();
        }

        //check uniqueId cookie
        $setCookie = false;
        $uniqueIdCookie = $request->cookies->get('michi_wordle_unique_id');

        // try to find by user
        if (!$uniqueIdCookie && $user instanceof User) {
            $statistic = $this->statisticService->findByUser($user);
            $uniqueIdCookie = $statistic->getUniqueKey();
            $setCookie = true;
        }

        // create new uniqueId cookie if needed
        if (!$uniqueIdCookie) {
            // If cookie doesn't exist, generate a new unique id
            $uniqueId = uniqid();
            $expireTime = time() + (60 * 60 * 24 * 365);
            $uniqueIdCookie = new Cookie('michi_wordle_unique_id', $uniqueId, $expireTime);
            $setCookie = true;
        }

        $totalAttempts = 6;
        if ($request->query->get('test')) {
            $totalAttempts = (int)$request->query->get('test');
        }

        $response = $this->render('times_game/index.html.twig', [
            'search' => $wordle,
            'wordleId' => $id,
            'totalAttempts' => $totalAttempts,
        ]);

        if ($setCookie) {
            $response->headers->setCookie($uniqueIdCookie);
        }

        return $response;
    }

    #[Route('/check', name: 'app_times_game_check', methods: ['POST'])]
    public function checkWord(Request $request, WordleCheckService $wordleCheckService): Response
    {
        $data = json_decode($request->getContent(), true);
        $word = $data['word'] ?? '';

        // Check if the word is valid using WordService
        $isValid = $wordleCheckService->isWordValid($word);

        // Return a JSON response with the result
        return new JsonResponse(['isValid' => $isValid]);
    }

    #[Route('/save', name: 'app_times_game_save', methods: ['POST'])]
    public function saveStatistic(Request $request): Response
    {
        $user = $this->getUser();

        // check cookie or otherwise we have to set new one
        $uniqueIdCookie = $request->cookies->get('michi_wordle_unique_id');

        if (!$uniqueIdCookie) {
            return new JsonResponse(['isValid' => false]);
        }

        $data = json_decode($request->getContent(), true);

        $difference = array_diff(self::NEEDED_KEYS, array_keys($data));

        if (count($difference) > 0) {
            return new JsonResponse(['isValid' => false]);
        }

        $updated = $this->statisticService->save($data, $user, $uniqueIdCookie);

        // Return a JSON response with the result
        return new JsonResponse(['isValid' => $updated]);
    }


    #[Route('/statistic', name: 'app_times_game_statistic', methods: ['POST'])]
    public function showStatistic(Request $request): Response
    {
        $user = $this->getUser();
        $statistic = null;
        if ($user !== null) {
            $statistic = $this->statisticService->findByUser($user);
        }

        if ($statistic === null) {
            $uniqueKey = $this->getCurrentDayCookie($request, self::KEY_UNIQUE_ID);
            if ($uniqueKey !== null) {
                $statistic = $this->statisticService->findByUser($user);
            }
        }

        return $this->render('times_game/statistic.html.twig', [
            'statistic' => $statistic
        ]);
    }

    private function getCurrentDayCookie(Request $request, string $parameter)
    {
        $currentDate = new DateTime();
        $currentDate->setTime(0, 0, 0);

        $dateString = $currentDate->format('Y-m-d');
        $cookieName = 'currentGameInfo_' . $dateString;

        //get the cookie
        $cookieValue = json_decode($request->cookies->get($cookieName), true);

        if (array_key_exists($parameter, $cookieValue)) {
            return $cookieValue[$parameter];
        }

        return null;
    }
}
