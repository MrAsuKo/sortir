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

        $theme = $request->query->get('theme-select');
        dd($theme);
        $cookie = new Cookie('theme', //Nom cookie
            '$theme', //Valeur
            strtotime('tomorrow'), //expire le
            '/', //Chemin de serveur
            'stacktraceback.com', //Nom domaine
            true, //Https seulement
            true);

        return $this->redirectToRoute('app_accueil');
    }
}
