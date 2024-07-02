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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/times/game')]
class TimesGameController extends AbstractController
{
    #[Route('/', name: 'app_times_game')]
    public function index(WordleRepository $wordleRepository): Response
    {
        $currentDate = new DateTime();
        $currentDate->setTime(0,0,0);
        $dailyWordle = $wordleRepository->findBy(['deliveryDate' => $currentDate]);

        $wordle = 'teste';
        if (count($dailyWordle)){
            $wordle = strtolower($dailyWordle[0]->getValue());
        }

        return $this->render('times_game/index.html.twig', [
            'search' => $wordle,
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
