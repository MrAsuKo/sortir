<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends AbstractController
{

    #[Route('/theme', name: 'theme_choix')]
    public function choix(
        Request $request
    ): Response
    {

        $theme = $request->query->get('themes');
        $response = New Response();
        $cookie = new Cookie('theme', $theme , strtotime('tomorrow'));
        $response->headers->setCookie($cookie);
        $response->send();


        return $this->redirectToRoute('app_accueil');
    }
}
