<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/esc')]
class EscController extends AbstractController
{
    #[Route('/vote', name: 'app_esc_vote')]
    public function index(): Response
    {
        $choices = [
            '1. Deutschland - Pimmel - Kopf',
            'Frankreich',
            'England',
            'Spanien',
            'Italien',
            'Ungarn',
            'Polen',
            'Schweden',
            'Dänemark',
            'Griechenland',
            'Niederlande',
        ];

        $fields = [
          '12 Punkte',
          '10 Punkte',
          '8 Punkte',
          '7 Punkte',
          '6 Punkte',
        ];

        return $this->render('esc/index.html.twig', [
            'choices' => $choices,
            'fields' => $fields,
        ]);
    }

    #[Route('/save', name: 'app_esc_save')]
    public function saveUserChoices(Request $request): Response
    {
        // Retrieve JSON data from the request body
        $jsonData = $request->getContent();

        dd($jsonData);

        // Optionally, you can return a response to the client
        return new Response('User choices saved successfully');
    }

    #[Route('/collect', name: 'app_esc_collect')]
    public function getUserChoices(Request $request): Response
    {
        // Retrieve user choices from the session
        $session = $request->getSession();
        $userChoices = $session->get('user_choices', []);

        // Serialize user choices to JSON
        $jsonData = json_encode($userChoices);

        // Return user choices as JSON response
        return new Response($jsonData);
    }
}
