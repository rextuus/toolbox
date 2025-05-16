<?php

namespace App\Controller;

use App\Entity\EscEvent;
use App\Esc\Content\Event\EscEventService;
use App\Esc\Content\Voting\Data\EscVotingData;
use App\Esc\Content\Voting\EscVotingRelation;
use App\Esc\Content\Voting\EscVotingService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/esc')]
class EscController extends AbstractController
{
    public function __construct(
        private readonly EscEventService $escEventService,
        private readonly EscVotingService $escVotingService,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/', name: 'app_esc_index')]
    public function index(): Response
    {
        return $this->render('esc/index.html.twig', [
        ]);
    }

    #[Route('/vote', name: 'app_esc_vote')]
    public function vote(): Response
    {
        $raw = [
            ["cy", "01", "Zypern", "Silia Kapsis", "Liar"],
            ["rs", "02", "Serbien", "Teya Dora", "Ramonda"],
            ["lt", "03", "Litauen", "Silvester Belt", "Luktelk"],
            ["ie", "04", "Irland", "Bambie Thug", "Doomsday Blue"],
            ["ua", "05", "Ukraine", "Alyona Alyona & Jerry Heil", "Teresa & Maria"],
            ["pl", "06", "Polen", "Luna", "The Tower"],
            ["hr", "07", "Kroatien", "Baby Lasagna", "Rim Tim Tagi Dim"],
            ["is", "08", "Island", "Hera Björk", "Scared Of Heights"],
            ["si", "09", "Slowenien", "Raiven", "Veronika"],
            ["fi", "10", "Finnland", "Windows95man", "No Rules"],
            ["md", "11", "Moldau", "Natalia Barbu", "In The Middle"],
            ["az", "12", "Aserbaidschan", "Fahree feat. Ilkin Dovlatov", "Özünlə Apar"],
            ["au", "13", "Australien", "Electric Fields", "One Milkali (One Blood)"],
            ["pt", "14", "Portugal", "Iolanda", "Grito"],
            ["lu", "15", "Luxemburg", "Tali", "Fighter"]
        ];

        $raw = [
            ['mt', "01", "Malta", "Sarah Bonnici", "Loop"],
            ['al', "02", "Albanien", "Besa", "Titan"],
            ['gr', "03", "Griechenland", "Marina Satti", "Zari"],
            ['ch', "04", "Schweiz", "Nemo", "The Code"],
            ['cz', "05", "Tschechien", "Aiko", "Pedestal"],
            ['at', "06", "Österreich", "Kaleen", "We Will Rave"],
            ['dk', "07", "Dänemark", "Saba", "Sand"],
            ['am', "08", "Armenien", "Ladaniva", "Jako"],
            ['lv', "09", "Lettland", "Dons", "Hollow"],
            ['sm', "10", "San Marino", "Megara", "11:11"],
            ['ge', "11", "Georgien", "Nutsa Buzaladze", "Fire Fighter"],
            ['be', "12", "Belgien", "Mustii", "Before The Party's Over"],
            ['ee', "13", "Estland", "5Miinust & Puuluup", "(Nendest) narkootikumidest ei tea me (küll) midagi"],
            ['il', "14", "Israel", "Eden Golan", "Hurricane"],
            ['no', "15", "Norwegen", "Gåte", "Ulveham"],
            ['nl', "16", "Niederlande", "Joost Klein", "Europapa"],
            ['de', "17", "Deutschland", "Isaak", "Always On The Run"],
            ['fr', "18", "Frankreich", "Slimane", "Mon amour"],
            ['gb', "19", "UK", "Olly Alexander", "Dizzy"],
            ['it', "20", "Italien", "Angelina Mango", "La noia"],
            ['se', "21", "Schweden", "Marcus & Martinus", "Unforgettable"],
            ['es', "22", "Spanien", "Nebulossa", "Zorra"]
        ];

        $final = [
            ['no', "01", "Norwegen", "Kyle Alessandro", "Lighter"],
            ['lu', "02", "Luxemburg", "Laura Thorn", "La poupée monte le son"],
            ['ee', "03", "Estland", "Tommy Cash", "Espresso Macchiato"],
            ['il', "04", "Israel", "Yuval Raphael", "New Day Will Rise"],
            ['lt', "05", "Litauen", "Katarsis", "Tavo Akys"],
            ['es', "06", "Spanien", "Melody", "Esa diva"],
            ['ua', "07", "Ukraine", "Ziferblat", "Bird Of Pray"],
            ['gb', "08", "Großbritannien", "Remember Monday", "What The Hell Just Happened?"],
            ['at', "09", "Österreich", "JJ", "Wasted Love"],
            ['is', "10", "Island", "VÆB", "Róa"],
            ['lv', "11", "Lettland", "Tautumeitas", "Bur man laimi"],
            ['nl', "12", "Niederlande", "Claude", "C'est la vie"],
            ['fi', "13", "Finnland", "Erika Vikman", "Ich komme"],
            ['it', "14", "Italien", "Lucio Corsi", "Volevo essere un duro"],
            ['pl', "15", "Polen", "Justyna Steczkowska", "Gaja"],
            ['de', "16", "Deutschland", "Abor & Tynna", "Baller"],
            ['gr', "17", "Griechenland", "Klavdia", "Asteromata"],
            ['am', "18", "Armenien", "Parg", "Survivor"],
            ['ch', "19", "Schweiz", "Zoë Më", "Voyage"],
            ['mt', "20", "Malta", "Miriana Conte", "Serving"],
            ['pt', "21", "Portugal", "NAPA", "Deslocado"],
            ['dk', "22", "Dänemark", "Sissal", "Hallucination"],
            ['se', "23", "Schweden", "KAJ", "Bara bada bastu"],
            ['fr', "24", "Frankreich", "Louane", "Maman"],
            ['sm', "25", "San Marino", "Gabry Ponte", "Tutta l'Italia"],
            ['al', "26", "Albanien", "Shkodra Elektronike", "Zjerm"],
        ];

        $activeEvent = $this->escEventService->getCurrentlyActiveEvent();

        if (count($activeEvent->getParticipantList()) === 0){
            $activeEvent->setParticipantList($final);
            $this->entityManager->persist($activeEvent);
            $this->entityManager->flush();
        }

        $choices = $this->getChoices($activeEvent->getParticipantList());

        $fields = [
            '12 Punkte',
            '10 Punkte',
            '8 Punkte',
            '7 Punkte',
            '6 Punkte',
            '5 Punkte',
            '4 Punkte',
            '3 Punkte',
            '2 Punkte',
            '1 Punkte',
        ];

        return $this->render('esc/vote.html.twig', [
            'choices' => $choices,
            'fields' => $fields,
        ]);
    }

    #[Route('/save', name: 'app_esc_save')]
    public function saveUserChoices(Request $request): Response
    {
        // Retrieve JSON data from the request body
        $data = json_decode($request->getContent(), true);

        $escVotingData = new EscVotingData();
        $escVotingData->setName(str_replace('"', '', $data['name']));

        foreach ($data['choices'] as $target => $choice) {
            preg_match('~target-([0-9]*)~', $target, $matches);
            preg_match('~choice-([0-9]*)~', $choice, $matches2);
            switch ($matches[1]) {
                case 1:
                    $escVotingData->setFirstChoice($matches2[1]);
                    break;
                case 2:
                    $escVotingData->setSecondChoice($matches2[1]);
                    break;
                case 3:
                    $escVotingData->setThirdChoice($matches2[1]);
                    break;
                case 4:
                    $escVotingData->setFirthChoice($matches2[1]);
                    break;
                case 5:
                    $escVotingData->setFifthChoice($matches2[1]);
                    break;
                case 6:
                    $escVotingData->setSixthChoice($matches2[1]);
                    break;
                case 7:
                    $escVotingData->setSeventhChoice($matches2[1]);
                    break;
                case 8:
                    $escVotingData->setEightChoice($matches2[1]);
                    break;
                case 9:
                    $escVotingData->setNinthChoice($matches2[1]);
                    break;
                case 10:
                    $escVotingData->setTenthChoice($matches2[1]);
                    break;
            }
        }

        $activeEvent = $this->escEventService->getCurrentlyActiveEvent();
        $escVotingData->setEscEvent($activeEvent);

        $this->escVotingService->createByData($escVotingData);

        // Optionally, you can return a response to the client
        return new JsonResponse('Success', 201);
    }

    #[Route('/result', name: 'app_esc_result')]
    public function getResult(Request $request): Response
    {
        $activeEvent = $this->escEventService->getCurrentlyActiveEvent();
        $choices = $this->getChoices($activeEvent->getParticipantList());

        $result = [];
        $participants = $activeEvent->getParticipantList();
        $participantNames = array_map(
            function (array $participant) {
                return $participant[2];
            },
            $participants
        );

        $flags = [];
        foreach ($participants as $participant) {
            $flags[$participant[2]] = $participant[0];
        }

        foreach ($activeEvent->getVotes() as $vote) {
            $votes = [
                $participants[$vote->getTenthChoice() - 1][2] => 1,
                $participants[$vote->getNinthChoice() - 1][2] => 2,
                $participants[$vote->getEightChoice() - 1][2] => 3,
                $participants[$vote->getSeventhChoice() - 1][2] => 4,
                $participants[$vote->getSixthChoice() - 1][2] => 5,
                $participants[$vote->getFifthChoice() - 1][2] => 6,
                $participants[$vote->getFirthChoice() - 1][2] => 7,
                $participants[$vote->getThirdChoice() - 1][2] => 8,
                $participants[$vote->getSecondChoice() - 1][2] => 10,
                $participants[$vote->getFirstChoice() - 1][2] => 12,
            ];
            $result[] = ['name' => $vote->getName(), 'votes' => $votes];
        }

        return $this->render('esc/result.html.twig', [
            'votesRaw' => json_encode($result),
            'participants' => $choices,
            'participantNames' => $participantNames,
            'flags' => $flags,
        ]);
    }


    #[Route('/previous-votes', name: 'app_esc_previous_votes')]
    public function previousVotes(Request $request): Response
    {
        $selectedUsername = null;
        $userVoting = null;
        $choices = null;

        // Get the votes cookie
        $votesCookie = $request->cookies->get('votes');
        $usernames = [];

        if ($votesCookie) {
            $usernames = json_decode($votesCookie, true);
            $usernames = array_map(
                function ($username) {
                    return str_replace('"', '', $username);
                },
                $usernames
            );
        }

        // If a username is selected in the form
        if ($request->query->has('username')) {
            $selectedUsername = $request->query->get('username');

            // Get the latest event
            $activeEvent = $this->escEventService->getCurrentlyActiveEvent();

            // Find the voting for this user
            $userVoting = $this->escVotingService->findOneByNameAndEvent($selectedUsername, $activeEvent);

            if ($userVoting) {
                // Get the choices for display
                $choices = $this->getChoices($activeEvent->getParticipantList());
            }
        }

        return $this->render('esc/previous_votes.html.twig', [
            'usernames' => $usernames,
            'selectedUsername' => $selectedUsername,
            'userVoting' => $userVoting,
            'choices' => $choices,
        ]);
    }

    #[Route('/result-overview', name: 'app_esc_result_overview')]
    public function getResultOverview(Request $request): Response
    {
        $activeEvent = $this->escEventService->getCurrentlyActiveEvent();
        $countryList = $activeEvent->getParticipantList();
        foreach ($countryList as $nr => $participant) {
            $participant['points'] = 0;
            $participant['place'] = 0;
            $participant['votesFrom'] = [];
            $countryList[$nr] = $participant;
        }

        $pointsToGive = [12, 10, 8, 7, 6, 5, 4, 3, 2, 1];
        foreach (EscVotingRelation::cases() as $voteNr => $choiceLevel) {
            $getter = $choiceLevel->getGetterForEscChoice();

            foreach ($activeEvent->getVotes() as $vote) {
                $countryId = $vote->$getter() - 1;
                $country = $countryList[$countryId];
                $country['points'] = $country['points'] + $pointsToGive[$voteNr];
                $country['votesFrom'][$vote->getName()] = $pointsToGive[$voteNr];
                $countryList[$countryId] = $country;
            }
        }

        usort(
            $countryList,
            function ($a, $b) {
                return $a['points'] <=> $b['points'];
            }
        );

        $countryList = array_reverse($countryList);
        foreach ($countryList as $nr => $country) {
            $country['place'] = (string)$nr + 1 . '.';
            $countryList[$nr] = $country;
        }

        $html = $this->getChoices($countryList, true);

        return $this->render('esc/result_overview.html.twig', [
            'entries' => $countryList,
            'htmls' => $html,
        ]);
    }

    /**
     * @return array<string>
     */
    private function getChoices(array $contributors, bool $placeAndPoints = false): array
    {
        $choices = [];
        foreach ($contributors as $contributor) {
            $additionalHtml = '';

            if ($placeAndPoints) {
                $additionalHtml = sprintf(
                    '
                <span class="placing-header">
                    <span class="place">%s</span>
                    <span class="points">%s Punkte</span>
                </span>
                        ',
                    $contributor['place'],
                    $contributor['points'],
                );
            }

            $choices[] = sprintf(
                '%s
                        <span>
                            <span class="flag fi fi-%s fis"></span>
                            <span class="country">%s</span>
                        </span>
                        <span>
                            <span class="artist">%s - </span> 
                            <span class="song">%s</span>
                        </span>
                        ',
                $additionalHtml,
                $contributor[0],
//                $contributor[1],
                $contributor[2],
                $contributor[3],
                $contributor[4]
            );
        }
        return $choices;
    }
}
