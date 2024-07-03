<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ParameterBagInterface $params, Request $request): Response
    {
        if (!str_contains($request->getRequestUri(), 'index.php')) {
            $url = $request->getSchemeAndHttpHost(). '/index.php' . $request->getRequestUri();
            return new RedirectResponse($url);
        }

        $useWorldHome = filter_var($this->getParameter('use_world_home'), FILTER_VALIDATE_BOOLEAN);
        if ($useWorldHome) {
            return $this->render('times_game/home.html.twig', ['now' => new DateTime(),]);
        }

        return $this->render('home_contoller/index.html.twig', [
            'controller_name' => 'HomeContollerController',
        ]);
    }
}
