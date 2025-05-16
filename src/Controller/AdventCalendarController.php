<?php

namespace App\Controller;

use App\AdventCalendar\DoorDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/calendar')]
class AdventCalendarController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route('/', name: 'app_calendar')]
    public function index(): Response
    {
        $doors = [];
        for ($i = 0; $i <= 23; $i++) {
            $doors[] = new DoorDTO($i, 'https://www.researchgate.net/profile/Donald-Bailey-5/publication/224624453/figure/fig1/AS:393833717223438@1470908683517/Original-colour-bar-static-test-image-used-in-analogue-television-II-METHODOLOGY.png'); // Placeholder image URL
        }

        return $this->render(
            'calendar/main.html.twig',
            [
                'doors' => $doors,
            ]
        );
    }
}
