<?php

namespace App\Controller;

use App\Esc\Content\Voting\Data\EscVotingData;
use App\Repository\WordleRepository;
use App\TimesGame\Content\Word\WordService;
use App\TimesGame\WiktionaryService;
use App\TimesGame\WordleCheckService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/times/game')]
class TimesGameController extends AbstractController
{
    #[Route('/', name: 'app_times_game')]
    public function index(Request $request, WordleRepository $wordleRepository): Response
    {
        $currentDate = new DateTime();
        $currentDate->setTime(0,0,0);
        $dailyWordle = $wordleRepository->findBy(['deliveryDate' => $currentDate]);

        $wordle = 'teste';
        if (count($dailyWordle)){
            $wordle = strtolower($dailyWordle[0]->getValue());
        }

        $dateString = $currentDate->format('Y-m-d');
        $cookieName = 'currentGameInfo_'.$dateString;

        //get the cookie
        $cookieValue = $request->cookies->get($cookieName);

        //The above line will give you the cookie value as a string.
        //Don't forget to parse it into an array or object by json_decode() if necessary.
        //Like so:
        $parsedCookieValue = json_decode($cookieValue);

//        dd($parsedCookieValue);


        $totalAttempts = 6;
        if ($request->query->get('test')){
            $totalAttempts = (int) $request->query->get('test');
        }

        return $this->render('times_game/index.html.twig', [
            'search' => $wordle,
            'totalAttempts' => $totalAttempts,
        ]);
    }

    #[Route('/test', name: 'app_times_game2')]
    public function test(WiktionaryService $wiktionaryService): Response
    {
        $res = $wiktionaryService->isPartOfGermanWiktionary('raupe');
        dd($res);
        return $this->render('times_game/index.html.twig', [
            'search' => 'teste',
        ]);
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
}
